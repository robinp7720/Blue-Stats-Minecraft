<h2>Theme</h2>
<div class="row">



    <?php

    $files = array_diff(scandir(ROOT . '/themes'), ['..', '.']);

    foreach ($files as $dir): ?>
        <?php
        if (!is_dir(ROOT . '/themes/'.$dir)) continue;
        $info = json_decode(file_get_contents(ROOT . '/themes/'.$dir.'/info.json'),true);
        ?>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=$info['name']?></h3>
                </div>
                <img src="../themes/<?=$dir?>/image.png" alt="" style="width: 100%;">
                <div class="panel-body">
                    <?=$info['description']?>
                </div>
                <div class="panel-footer">
                    <div class="clearfix">
                        <span class="btn btn-success pull-right" data-plugin="BlueStats" data-option="theme" data-value="<?=$dir?>">Set</span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<script>
    $('span.btn').click(function(e) {
        $.ajax('advanced/actions/setConfig.php', {
            method: 'post',
            dataType: 'json',
            data: {
                plugin: $(this).data('plugin'),
                option: $(this).data('option'),
                value:  $(this).data('value')
            }
        }).success(function (data) {
            if (data["success"] == true) {
                $('.messages').append('<div class="alert alert-success alert-dismissible">' +
                    '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                    '    <strong>Success!</strong> The new theme has been set successfully' +
                    '  </div>')
            } else {
                $('.messages').append('<div class="alert alert-danger alert-dismissible">' +
                    '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                    '    <strong>Error!</strong> An error has occurred while setting the theme' +
                    '  </div>')
            }
        });
    })
</script>