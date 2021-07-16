<style type="text/css">
    #ContactFormResponseLarge {
        display:none;
        transition: ;
    }

    #ContactFormResponseLarge.show {
        transition: opacity 0.4s ease-in-out;
        transition-delay: 0.3s;
        visibility: visible;
        display: block;
    }
</style>

<article id="contact" class="contact-form">
    <div class="row">
        <div class="col-md-12">
            <h1 class="section-title"><?php esc_html_e( 'Kontakt oss', 'brimo' ); ?></h1>
            <div id="ContactFormResponseLarge">
                <!-- here message will be displayed -->
            </div>
        </div>
        <?php
            $get_widget_order = brimo_get_theme_option( 'contact_widget_placement' );
            $widget_order = $get_widget_order == "2" ? 'order-last' : '';
        ?>
        <div class="col mt-2 <?php echo $widget_order; ?>">
            <form id="ContactFormLarge" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="contact_send" />
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="message_name_large" name="message_name" placeholder=" <?php esc_html_e( 'Navn', 'brimo' );?>" value="<?php echo isset( $_POST['message_name'] ) ? esc_attr( $_POST['message_name'] ) : ''; ?>" required>
                    <label for="message_name"><?php esc_html_e( 'Navn:', 'brimo' ); ?></label>
                </div>
                <div class="form-floating mb-2">
                    <input type="email" class="form-control" id="message_email_large" name="message_email" placeholder=" <?php esc_html_e( 'Email', 'brimo' );?>" value="<?php echo isset( $_POST['message_email'] ) ? esc_attr( $_POST['message_email'] ) : ''; ?>" required>
                    <label for="message_email"><?php esc_html_e( 'Epost:', 'brimo' ); ?></label>
                </div>
                <div class="form-floating mb-2">
                    <textarea class="form-control" id="message_text_large" name="message_text" placeholder="<?php esc_html_e( 'Melding..', 'brimo' ); ?>" required><?php echo isset($_POST['message_text'] ) ? esc_textarea( $_POST['message_text'] ) : ''; ?></textarea>
                    <label for="message_text"><?php esc_html_e( 'Din melding:', 'brimo' ); ?></label>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">2 + 2 = </span>
                    <input type="text" class="form-control" id="message_human_large" name="message_human" placeholder="<?php esc_html_e( 'Menneskelig verifisering:', 'brimo' ); ?>" required>
                    <button type="submit" class="btn btn-brimo"><i class="fa icon-fixed-width fa-paper-plane" aria-hidden="true"></i>&nbsp;Send</button>
                    <div class="invalid-feedback"><?php esc_html_e( 'Vennligst fyll ut dette feltet', 'brimo' ); ?></div>
                </div>
            </form>
        </div>

        <?php if ( function_exists( 'dynamic_sidebar' ) && is_active_sidebar( 'contact-widgets' ) ) : ?>

        <div class="col-md-6 mt-2">
            <!-- BEGIN: CONTACT WIDGETS -->
            <div id="widgets-contact" class="container"><?php dynamic_sidebar( 'contact-widgets' ); ?></div>
            <!-- END: CONTACT WIDGETS -->
        </div>

        <?php endif; ?>
    </div>
</article>

<script>
    jQuery(document).ready(function ($) {
        <?php get_template_part( 'template-parts/contact-form-strings.inc' ); ?>
        // Hide response div.
        $("#ContactFormResponseLarge").fadeOut();

        var is_sending = false;

        jQuery('#ContactFormLarge').submit(function (e) {
            e.preventDefault(); // Prevent the default form submit

            if (is_sending || !validateInputs()) {
                // Don't let someone submit the form while it is in-progress.
                return false;
            }
            $this = $(this); // Cache this

            jQuery.ajax({
                url: '<?php echo admin_url("admin-ajax.php") ?>', // Let WordPress figure this url out.
                type: 'post',
                dataType: 'JSON', // Set this so we don't need to decode the response.
                data: $this.serialize(), // One-liner form data prep.
                beforeSend: function () {
                    is_sending = true;
                    jQuery("#ContactFormResponseLarge").fadeIn('slow', function(){
                        jQuery("#ContactFormResponseLarge").html('<div class="alert alert-info" role="alert">'+message_sending+'</div>');
                    });
                },
                error: handleFormError(),
                success: function (data) {
                    if (data.status === 'success') {
                        jQuery("#ContactFormResponseLarge").fadeIn('slow', function(){
                            jQuery("#ContactFormResponseLarge").html('<div class="alert alert-success" role="alert">'+message_sent+'</div>');
                            jQuery("#ContactFormResponseLarge").delay(10000).fadeOut();
                        });
                        is_sending = false;
                        jQuery('#ContactFormLarge')[0].reset();
                        jQuery("#message_human_large").closest('div').removeClass('has-error');
                        jQuery("#ContactFormLarge").removeClass('was-validated');
                    } else {
                        // If we don't get the expected response, it's an error.
                        handleFormError(data.message);
                    }
                }
            });
        });

        function handleFormError(error = '') {
            // Reset the is_sending var so they can try again.
            is_sending = false;

            jQuery("#ContactFormResponseLarge").fadeIn('slow', function(){
                jQuery("#ContactFormResponseLarge").html('<div class="alert alert-danger" role="alert">'+failure_message+'<br/>'+error+'</div>');
            });
        }


        function validateInputs () {
            var $human = jQuery('#message_human_large').val(),
                $name = jQuery('#message_name_large').val(),
                $email = jQuery('#message_email_large').val(),
                $message = jQuery('#message_text_large').val();
            if ($human != "4") {
                jQuery("#ContactFormLarge").addClass('was-validated');
                jQuery("#ContactFormResponseLarge").fadeIn('slow', function(){
                    jQuery("#ContactFormResponseLarge").html('<div class="alert alert-danger" role="alert">'+not_human+'</div>');
                    jQuery("#message_human_large").closest('div').addClass('has-error');
                });
                return false;
            } else if (!$name || !$email || !$message) {
                jQuery("#ContactFormLarge").addClass('was-validated');
                jQuery("#ContactFormResponseLarge").fadeIn('slow', function(){
                    jQuery("#ContactFormResponseLarge").html('<div class="alert alert-warning" role="alert">'+missing_content+'</div>');
                });
                return false;
            }
            return true;
        }
    });
</script>
