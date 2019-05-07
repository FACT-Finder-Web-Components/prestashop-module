(function ($) {
    $.widget('factfinder.ajaxAction', {
        options: {
            actionUrl: 'modules/factfinder/test',
            buttonId: '#ffTestConnection',
            method: 'POST',
            payload: {},
            onSuccess: function (res) {
                jAlert(res.responseText);
            },
            onError: function (res) {
                var data = res.responseJSON || {};
                jAlert(data.responseText + '\n' + data.errors.join('\n'));
            }
        },

        _create: function () {
            var actionUrl = window.baseAdminDir + this.options.actionUrl,
                icon = this.element.find('i'),
                iconLoading = 'process-icon-loading',
                method = this.options.method,
                payload = typeof this.options.payload === 'function' ? this.options.payload.bind(this) : function () {
                    return this.options.payload;
                }.bind(this),
                onSuccess = this.options.onSuccess.bind(this),
                onError = this.options.onError.bind(this);

            this._on(this.element, {
                'click': $.proxy(function () {
                    icon.addClass(iconLoading);

                    this._ajax(actionUrl, method, payload())
                        .done(onSuccess)
                        .fail(onError)
                        .always(function () {
                            return icon.removeClass(iconLoading);
                        });
                }, this)
            });
        },

        _ajax: function (url, method, payload) {
            return $.ajax({
                type: method,
                cache: false,
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify(payload),
                url: url
            });
        }
    });
})(jQuery);
