<style type="text/css">
    #ContactFormResponeLarge{
        display:none;
    }
</style>

<article class="contact-form">
    <div class="row">
        <div class="col-md-12">
            <h1 class="section-title">Kontakt oss</h1>
            <div id="ContactFormResponeLarge">
                <!-- here message will be displayed -->
            </div>
        </div>
        <div class="col-md-6 mt-2">
            <form id="ContactFormLarge">
                <div class="form-group">
                    <input type="hidden" name="action" value="contact_send" />
                    <select name="message_to" class="custom-select">
                        <option selected>Velg mottaker</option>
                        <option value="styre@reipaabf.no">Styret</option>
                        <option value="leder@reipaabf.no">Leder</option>
                        <option value="kasserer@reipaabf.no">Kasserer</option>
                        <option value="havnesjef@reipaabf.no">Havnesjef</option>
                        <option value="webmaster@reipaabf.no">Webmaster</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message_name"><?php echo(esc_html__( 'Navn:', 'brimo' )); ?></label>
                    <input type="text" class="form-control" id="message_name_large" name="message_name" placeholder=" <?php echo __('Navn', 'brimo');?>" value="<?php echo isset($_POST['message_name'])?esc_attr($_POST['message_name']):''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="message_email"><?php echo(esc_html__( 'Epost:', 'brimo' )); ?></label>
                    <input type="email" class="form-control" id="message_email_large" name="message_email" placeholder=" <?php echo __('Email', 'brimo');?>" value="<?php echo isset($_POST['message_email'])?esc_attr($_POST['message_email']):''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="message_text"><?php echo(esc_html__( 'Din melding:', 'brimo' )); ?></label>
                    <textarea class="form-control" id="message_text_large" name="message_text" placeholder="Melding.." required><?php echo(isset($_POST['message_text'])?esc_textarea($_POST['message_text']):''); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="message_human"><?php echo(esc_html__( 'Menneskelig verifisering:', 'brimo' )); ?></label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="message_human_large" name="message_human" required>
                        <div class="input-group-append">
                            <span class="input-group-text">+ 3 = 5</span>
                            <span>&nbsp;</span>
                            <button type="submit" class="btn btn-rbf contact-submit"><i class="fa icon-fixed-width fa-paper-plane" aria-hidden="true"></i>&nbsp;Send</button>
                        </div>
                        <div class="invalid-feedback">Vennligst fyll ut dette feltet</div>

                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
        <!-- BEGIN: BOTTOM WIDGETS -->
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("contact-widget") ) : ?>
            <?php endif; ?>
            <!-- END: BOTTOM WIDGETS -->
        </div>
    </div>
</article>

<script>
    $(document).ready(function ($) {
        <?php get_template_part( 'template-parts/contact-form-strings.inc' ); ?>
        // Hide response div.
        $("#ContactFormResponeLarge").fadeOut();

        var is_sending = false;

        $('#ContactFormLarge').submit(function (e) {
            e.preventDefault(); // Prevent the default form submit

            if (is_sending || !validateInputs()) {
                // Don't let someone submit the form while it is in-progress.
                return false;
            }
            $this = $(this); // Cache this

            $.ajax({
                url: '<?php echo admin_url("admin-ajax.php") ?>', // Let WordPress figure this url out.
                type: 'post',
                dataType: 'JSON', // Set this so we don't need to decode the response.
                data: $this.serialize(), // One-liner form data prep.
                beforeSend: function () {
                    is_sending = true;
                    $("#ContactFormResponeLarge").fadeIn('slow', function(){
                        $("#ContactFormResponeLarge").html('<div class="alert alert-info" role="alert">'+message_sending+'</div>');
                    });
                },
                error: handleFormError,
                success: function (data) {
                    if (data.status === 'success') {
                        $("#ContactFormResponeLarge").fadeIn('slow', function(){
                            $("#ContactFormResponeLarge").html('<div class="alert alert-success" role="alert">'+message_sent+'</div>');
                            $("#ContactFormResponeLarge").delay(10000).fadeOut();
                        });
                        is_sending = false;
                        $('#ContactFormLarge')[0].reset();
                        $("#message_human_large").closest('div').removeClass('has-error');
                        $("#ContactFormLarge").removeClass('was-validated');
                    } else {
                        // If we don't get the expected response, it's an error.
                        handleFormError();
                    }
                }
            });
        });

        function handleFormError() {
            // Reset the is_sending var so they can try again.
            is_sending = false;

            $("#ContactFormResponeLarge").fadeIn('slow', function(){
                $("#ContactFormResponeLarge").html('<div class="alert alert-danger" role="alert">'+failure_message+'</div>');
            });
        }


        function validateInputs () {
            var $human = $('#message_human_large').val(),
                $name = $('#message_name_large').val(),
                $email = $('#message_email_large').val(),
                $message = $('#message_text_large').val();
            if ($human != "2") {
                $("#ContactFormLarge").addClass('was-validated');
                $("#ContactFormResponeLarge").fadeIn('slow', function(){
                    $("#ContactFormResponeLarge").html('<div class="alert alert-danger" role="alert">'+not_human+'</div>');
                    $("#message_human_large").closest('div').addClass('has-error');
                });
                return false;
            } else if (!$name || !$email || !$message) {
                $("#ContactFormLarge").addClass('was-validated');
                $("#ContactFormResponeLarge").fadeIn('slow', function(){
                    $("#ContactFormResponeLarge").html('<div class="alert alert-warning" role="alert">'+missing_content+'</div>');
                });
                return false;
            }
            return true;
        }
    });
</script>
