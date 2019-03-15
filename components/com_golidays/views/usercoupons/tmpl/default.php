
<?php
$user = JFactory::getUser();
$userId = GolidaysHelper::getUserId($user->id);

$token = JSession::getFormToken();
?>
<div class="wrapper">
	<!-- Header-->
	<h2><?php echo "Coupon" ?></h2>
	<div class="form-group">
		<label for="coupon-token">Token:</label>
		<input type="text" class="form-control" id="token">
	</div>

	<div class="form-group">
		<label for="coupon-token">Coupon:</label>
		<input type="text" class="form-control" id="coupon-token">
		<input type="button" class="btn btn-success btn-use-coupon" value="Used">
	</div>
</div>

<script>
    jQuery( document ).ready(function($) {
        var data = {};
        var url_used_coupon =  "<?php echo JUri::root() . 'index.php?option=com_api&app=users&resource=users&format=raw'?>";

        $('body ').on('click', '.btn-use-coupon', (function (e) {

            e.preventDefault();
            var data = {};

            data["token"] = $("#token").val();
            data["coupon"] = $("#coupon-token").val();

            console.log(data)
            $.ajax({
                url: url_used_coupon,
                type: "PUT",
                data: data,
                dataType: "json",
                beforeSend: function (xhr) {

                },
                success: function (data, status, jqXHR) {
                    if (data.data.code == 200) {
                        var msg1 = {
                            success: ["use successful"],
                        };
                        Joomla.renderMessages( msg1 );
                    }
                },
                error: function (jqXHR, status, err) {

                },
                complete: function (jqXHR, status) {

                }
            })
        }))
    });

</script>