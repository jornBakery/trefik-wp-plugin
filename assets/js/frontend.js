jQuery(function($) {
    
    
    // Create a function to handle category warnings
    function handleCategoryWarning(data) {
        if (confirm(data.message)) {
            // User confirmed, add the product to cart with a special flag
            $.post(TREFIK.ajax_url, {
                action: 'add_to_cart_override',
                nonce: TREFIK.nonce,
                product_id: data.product_id,
                quantity: data.quantity,
                override_category_check: true
            }, function(response) {
                if (response.success) {
                    // Refresh the cart
                    window.location.reload();
                } else {
                    alert(response.data || TREFIK.cart_strings.addToCartError);
                }
            });
        }
    }
    
    // Override the default add to cart behavior to handle category warnings
    $(document).on('click', '.single_add_to_cart_button', function(e) {
        const $thisbutton = $(this);
        const $form = $thisbutton.closest('form.cart');
        
        // Only if this is an AJAX add to cart button
        if ($thisbutton.hasClass('ajax_add_to_cart')) {
            return; // Let WooCommerce handle it
        }
        
        // Don't do anything if this is a variation form without selection
        if ($form.find('.variations select').length && !$form.find('input[name="variation_id"]').val()) {
            return;
        }
        
        e.preventDefault();
        
        const product_id = $form.find('input[name=product_id]').val() || $thisbutton.val();
        const variation_id = $form.find('input[name=variation_id]').val() || 0;
        const quantity = $form.find('input[name=quantity]').val() || 1;
        const variation_form = $form.hasClass('variations_form');
        const variations = {};
        
        if (variation_form) {
            $form.find('select[name^=attribute]').each(function() {
                const attribute = $(this).attr('name');
                const attributevalue = $(this).val();
                variations[attribute] = attributevalue;
            });
        }
        
        const data = {
            action: 'add_to_cart_override',
            product_id: product_id,
            product_sku: '',
            quantity: quantity,
            variation_id: variation_id,
            variations: variations,
            nonce: TREFIK.nonce
        };
        
        // Add loading class
        $thisbutton.addClass('loading');
        
        // AJAX add to cart
        $.post(TREFIK.ajax_url, data, function(response) {
            if (response.success) {
                // Product added successfully
                window.location.reload();
            } else if (response.data && response.data.category_warning) {
                // Handle category warning
                $thisbutton.removeClass('loading');
                handleCategoryWarning(response.data);
            } else {
                // Error
                $thisbutton.removeClass('loading');
                alert(response.data || TREFIK.cart_strings.addToCartError);
            }
        });
    });
    
    // function trefik_checkout_reorder_2() {
    //     $(document).find('.woolentor-cart-product-content-left').each(function() {
    //         const trefikVarationButtonGroup = $(this).find('.variation-switcher-form');
    //         if(trefikVarationButtonGroup) {
    //             // $(this).append(trefikVarationButtonGroup);
    //             console.log('append');
    //         }
    //     });
    // }
    
    // Handle remove cart item click
    $(document).on('click', '.remove-cart-item', function(e) {
        e.preventDefault();
        const cartKey = $(this).data('cart-key');
        
        if (!cartKey) return;
        
        if (confirm(TREFIK.cart_strings.removeFromCartConfirmation)) {
          jQuery.post(
            TREFIK.ajax_url,
            {
              action: "remove_cart_item",
              nonce: TREFIK.nonce,
              cart_item_key: cartKey,
            },
            function (response) {
              if (response.success) {
                // $('body').trigger('update_checkout');
                if (response.data.html)
                  refresh_cart_product_list(response.data.html);
                if (response.data.is_cart_empty) window.location.reload();
              } else {
                alert(response.data || TREFIK.cart_strings.removeFromCartError);
              }
            }
          );
        }
    });

    // Vervang form submit door dropdown change
    $(document).on('click', '.variation-switcher-form .btn-group button', function (e) {
        e.preventDefault();
        const $form = $(this).closest('.variation-switcher-form');
        const cartKey = $form.data('cart-key');
        const productId = $form.data('product-id');
        const attributes = {};
        const name = $(this).closest(".btn-group").attr("data-attribute");
        const value = $(this).attr("data-value");
         
        if (value) attributes[name] = value;

        if(!value) return;
        
        $.post(TREFIK.ajax_url, {
            action: 'switch_cart_variation',
            nonce: TREFIK.nonce,
            cart_item_key: cartKey,
            product_id: productId,
            attributes: attributes
        }, function (response) {
            if (response.success) {
                $('body').trigger('update_checkout');
                if (response.data.html) refresh_cart_product_list(response.data.html);
            } else {
                alert(response.data || TREFIK.cart_strings.genericError);
            }
        });
    });

    function refresh_cart_product_list(html) {
        $('#trefik_cart_product_list').html(html);
    }
});