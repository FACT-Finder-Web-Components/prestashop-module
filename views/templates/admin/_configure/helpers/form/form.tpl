{extends file='helpers/form/form.tpl'}

{block name='script'}
{literal}
    jQuery(function($) {
        $('#ffExportFeed').ajaxAction({buttonId: '#ffExportFeed', actionUrl: 'modules/factfinder/export'});
        $('#ffTestConnection').ajaxAction({
            payload: function() {
                return {
                    url: $('#FF_SERVER_URL_' + id_language).val() || $('#FF_SERVER_URL').val(),
                    channel: $('#FF_CHANNEL_' + id_language).val() || $('#FF_CHANNEL').val(),
                    username: $('#FF_USERNAME_' + id_language).val() || $('#FF_USERNAME').val(),
                    password: $('#FF_PASSWORD_' + id_language).val() || $('#FF_PASSWORD').val(),
                    authenticationPrefix: $('#FF_AUTHENTICATION_PREFIX_' + id_language).val() || $('#FF_AUTHENTICATION_PREFIX').val(),
                    authenticationPostfix: $('#FF_AUTHENTICATION_POSTFIX_' + id_language).val() || $('#FF_AUTHENTICATION_POSTFIX').val(),
                }
            }
        });
    });
{/literal}
{/block}
