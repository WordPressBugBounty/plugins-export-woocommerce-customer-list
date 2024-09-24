(function ($) {
    'use strict';

    jQuery(function ($) {

        function ajaxExportOfCSV() {
            this.init = function () {
                this.exportGuest();
                this.abortDownload();
                this.closeBlocker();
            }

            this.exportGuest = function () {
                var parent = this;
                jQuery("#ewcl-download-registered-record").on('submit', function (e) {
                    e.preventDefault();
                    var data = jQuery(this).serialize();
                    $(".bootstrap-wrapper").append('<div id="pi-extracting"><div class="alert alert-info"><span class="mx-1">0</span> Registered User data extracted <a href="javascript:void()" class="btn btn-danger mx-2" id="pi-cancel-download">Cancel Download</a></div> </div>');
                    parent.ajaxCall(0, data, 0, "");
                })
            }

            this.abortDownload = function () {
                var parent = this;
                jQuery(document).on('click', '#pi-cancel-download', function (e) {
                    e.preventDefault();
                    $("#pi-extracting").html('<div class="alert alert-info">Cancelling the download process</div>');
                    parent.ajax_request.abort();

                })
            }


            this.ajaxCall = function (step, data, row_extracted = 0, file_name = "") {
                var parent = this;
                var extra_data = '&action=' + 'pisol_ewcl_export_registered_data' + '&step=' + step + '&row_extracted=' + row_extracted + '&file_name=' + file_name;

                this.ajax_request = $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: data + extra_data,
                    dataType: "json",
                    success: function (response) {
                        if ('done' == response.step) {

                            if (response.row_extracted == 0) {
                                $("#pi-extracting").html('<div class="alert alert-danger">No customer found modify your selection criteria and try again</div>');
                                setTimeout(function () { $('#pi-extracting').remove(); }, 2000);
                                return;
                            }

                            parent.downloadCompleted(response.download_url);
                            window.location = response.download_url;

                        } else {
                            $("#pi-extracting span").html(response.row_extracted);
                            parent.ajaxCall(parseInt(response.step), data, response.row_extracted, response.file_name);
                        }

                    }
                }).fail(function (response) {
                    if (window.console && window.console.log) {
                        if (response && response.responseJSON && response.responseJSON.error) {
                            console.log(response.responseJSON);
                            $("#pi-extracting").html('<div class="alert alert-danger">' + response.responseJSON.error + '</div>');
                        }
                        setTimeout(function () { $('#pi-extracting').remove(); }, 3000);
                    }
                });
            }

            this.downloadCompleted = function (download_link) {
                $("#pi-extracting").html('<div class="alert alert-info">Your Download will start in few second, if not started click on this link <a href="' + download_link + '" download>Download now</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }

            this.closeBlocker = function () {
                jQuery(document).on('click', '#pi-extracting .close', function () {
                    $('#pi-extracting').remove();
                })
            }
        }

        var ajaxExportOfCSV_obj = new ajaxExportOfCSV();
        ajaxExportOfCSV_obj.init();

    });

})(jQuery);