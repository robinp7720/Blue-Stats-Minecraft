<h2>Query</h2>
<div class="row">
    <div class="col-md-12">
        <div class="btn-group" role="group">
            <a href="" class="btn btn-success plugin-action plugin-query-enable" data-action="enable"
               data-plugin="query">Enable</a>
            <a href="" class="btn btn-danger plugin-action plugin-query-disable" data-action="disable"
               data-plugin="query">Disable</a>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="form-horizontal">
                    <div class="input-group">
                        <span class="input-group-addon" id="ip-addon">IP</span>
                        <input type="text" class="form-control" aria-describedby="ip-addon" id="ip">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" id="port-addon">Port</span>
                        <input type="text" class="form-control" aria-describedby="port-addon" id="port">
                    </div>
                </div>
                <br>
                <a href="" class="btn btn-primary pull-right" id="save-btn">Save</a>
            </div>
        </div>
    </div>
</div>

<script>
    function getPluginStatus(plugin) {
        $.ajax('advanced/actions/plugin.php', {
            method: 'post',
            dataType: 'json',
            data: {
                plugin: plugin,
                action: 'status'
            }
        }).success(function (data) {
            console.log(data);
            if (data) {
                $('.plugin-' + plugin + '-enable').attr('class', "btn btn-success plugin-action plugin-query-enable");
                $('.plugin-' + plugin + '-disable').attr('class', "btn btn-default plugin-action plugin-query-disable");
            } else {
                $('.plugin-' + plugin + '-enable').attr('class', "btn btn-default plugin-action plugin-query-enable");
                $('.plugin-' + plugin + '-disable').attr('class', "btn btn-danger plugin-action plugin-query-disable");
            }
        });
    }

    getPluginStatus('query');

    $('.plugin-action').click(function (e) {
        e.preventDefault();
        var button = this;
        $.ajax('advanced/actions/plugin.php', {
            method: 'post',
            dataType: 'json',
            data: {
                plugin: $(this).data('plugin'),
                action: $(this).data('action')
            }
        }).success(function (data) {
            getPluginStatus($(button).data('plugin'));
            if (data["code"] == 200) {
                $('.messages').append('<div class="alert alert-success alert-dismissible">' +
                    '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                    '    <strong>Success!</strong> ' + $(button).data('plugin') + ' has been ' + $(button).data('action') + 'd' +
                    '  </div>')
            } else {
                $('.messages').append('<div class="alert alert-danger alert-dismissible">' +
                    '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                    '    <strong>Error!</strong>' + $(button).data('plugin') + ' has not been ' + $(button).data('action') + 'd' +
                    '  </div>')
            }
        });
    });

    $('#save-btn').click(function(e) {
        e.preventDefault();
        $.ajax('advanced/actions/setConfig.php', {
            method: 'post',
            dataType: 'json',
            data: {
                plugin: 'query',
                option: 'ip',
                value:  $('#ip').val()
            }
        }).success(function (data) {
                $.ajax('advanced/actions/setConfig.php', {
                    method: 'post',
                    dataType: 'json',
                    data: {
                        plugin: 'query',
                        option: 'port',
                        value:  $('#port').val()
                    }
                }).success(function (data) {
                    if (data["success"] == true) {
                        $('.messages').append('<div class="alert alert-success alert-dismissible">' +
                            '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                            '    <strong>Success!</strong> IP and Port has been set successfully' +
                            '  </div>')
                    } else {
                        $('.messages').append('<div class="alert alert-danger alert-dismissible">' +
                            '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                            '    <strong>Error!</strong> An error has occurred while setting the IP and Port' +
                            '  </div>')
                    }
                });

    })
        });
</script>