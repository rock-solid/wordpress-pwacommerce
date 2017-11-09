function PWACOMMERCE_SETTINGS() {
  var JSObject = this;

  this.type = 'pwacommerce_settings';

  this.form;
  this.DOMDoc;

  this.send_btn;

  /**
   * Init function called from PWACJSInterface
   */
  this.init = function() {
    // save a reference to PWACJSInterface Object
    PWACJSInterface = window.parent.PWACJSInterface;

    // save a reference to "SEND" Button
    this.send_btn = jQuery('#' + this.type + '_send_btn', this.DOMDoc).get(0);

    // save a reference to the FORM and remove the default submit action
    this.form = this.DOMDoc.getElementById(this.type + '_form');

    // add actions to send, cancel, ... buttons
    this.addButtonsActions();

    if (this.form == null) {
      return;
    }

    this.initValidation();
  };

  /**
   * Validate form data
   */
  this.initValidation = function() {
    jQuery.validator.addMethod(
      'regex',
      function(value, element, regexp) {
        var re = new RegExp(regexp, 'i');

        return this.optional(element) || re.test(value);
      },
      'Your code is invalid'
    );

    // this is the object that handles the form validations
    this.validator = jQuery('#' + this.form.id, this.DOMDoc).validate({
      rules: {
        pwacommerce_settings_analyticsid: {
          regex: '^ua-\\d{4,9}-\\d{1,4}$'
        }
      },

      // the errorPlacement has to take the table layout into account
      // all the errors must be handled by containers/divs with custom ids: Ex. "error_fullname_container"
      errorPlacement: function(error, element) {
        var split_name = element[0].id.split('_');
        var id =
          split_name.length > 1
            ? split_name[split_name.length - 1]
            : split_name[0];
        var errorContainer = jQuery(
          '#error_' + id + '_container',
          JSObject.DOMDoc
        );
        error.appendTo(errorContainer);
      },

      errorElement: 'span'
    });

    jQuery(
      '#pwacommerce_settings_service_worker_installed_check',
      JSObject.DOMDoc
    ).change(function() {
      // set the value on the dummy text field that will always be visible in the post data
      if (this.checked) {
        jQuery(
          '#' + JSObject.type + '_service_worker_installed',
          JSObject.DOMDoc
        ).val('1');
      } else {
        jQuery(
          '#' + JSObject.type + '_service_worker_installed',
          JSObject.DOMDoc
        ).val('0');
      }
    });

    var $GoogleAnalyticsId = jQuery(
      '#' + this.type + '_analyticsid',
      this.form
    );
    $GoogleAnalyticsId.data('holder', $GoogleAnalyticsId.attr('placeholder'));
    $GoogleAnalyticsId
      .focusin(function() {
        jQuery(this).attr('placeholder', '');
      })
      .focusout(function() {
        jQuery(this).attr('placeholder', jQuery(this).data('holder'));
      });
  };

  /**
     * Function that controls the actions of the send button.
     */
  this.addButtonsActions = function() {
    jQuery(this.send_btn).unbind('click');
    jQuery(this.send_btn).bind('click', function() {
      JSObject.disableButton(this);
      JSObject.validate();
    });
    JSObject.enableButton(this.send_btn);
  };

  /**
     * Function used to enable button after sending data.
     */
  this.enableButton = function(btn) {
    jQuery(btn).css('cursor', 'pointer');
    jQuery(btn).animate({ opacity: 1 }, 100);
  };

  /**
     * Function used to disable button while sending data.
     */
  this.disableButton = function(btn) {
    jQuery(btn).unbind('click');
    jQuery(btn).animate({ opacity: 0.4 }, 100);
    jQuery(btn).css('cursor', 'default');
  };

  /**
     * Validate data.
     */
  this.validate = function() {
    jQuery(this.form)
      .validate()
      .form();

    // y coordinates of error inputs
    var arr_errorsYCoord = [];

    // find the y coordinate for the errors
    for (var name in this.validator.invalid) {
      var input = jQuery(this.form[name]);
      arr_errorsYCoord.push(input.offset().top);
    }

    // if there are no errors from syntax point of view, then send data
    if (arr_errorsYCoord.length == 0) {
      JSObject.sendData();
    } else {
      // add actions to send, cancel, ... buttons. At this moment the buttons are disabled.
      JSObject.addButtonsActions();
    }
  };

  /**
     * Function that submits the form through an iframe as a target.
     */
  this.submitForm = function() {
    return PWACJSInterface.AjaxUpload.dosubmit(JSObject.form, {
      onStart: JSObject.startUploadingData,
      onComplete: JSObject.completeUploadingData
    });
  };

  /**
     * Function that sends the form data.
     */
  this.sendData = function() {
    jQuery('#' + this.form.id, this.DOMDoc).unbind('submit');
    jQuery('#' + this.form.id, this.DOMDoc).bind('submit', function() {
      JSObject.submitForm();
    });
    jQuery('#' + this.form.id, this.DOMDoc).submit();

    JSObject.disableButton(JSObject.send_btn);
  };

  /**
     * Function that starts uploading the data.
     */
  this.startUploadingData = function() {
    PWACJSInterface.Preloader.start();

    //disable form elements
    setTimeout(function() {
      var aElems = JSObject.form.elements;
      nElems = aElems.length;

      for (j = 0; j < nElems; j++) {
        aElems[j].disabled = true;
      }
    }, 300);

    return true;
  };

  /**
     * Function that runs once the data upload is complete.
     */
  this.completeUploadingData = function(responseJSON) {
    jQuery('#' + JSObject.form.id, JSObject.DOMDoc).unbind('submit');
    jQuery('#' + JSObject.form.id, JSObject.DOMDoc).bind('submit', function() {
      return false;
    });

    // remove preloader
    PWACJSInterface.Preloader.remove(100);

    var parsedJSON = JSON.parse(responseJSON);
    var response = Boolean(Number(String(parsedJSON.status)));

    PWACJSInterface.Loader.display({ message: parsedJSON.message });

    // enable form elements
    setTimeout(function() {
      var aElems = JSObject.form.elements;
      nElems = aElems.length;
      for (j = 0; j < nElems; j++) {
        aElems[j].disabled = false;
      }
    }, 300);

    //enable buttons
    JSObject.addButtonsActions();
  };
}
