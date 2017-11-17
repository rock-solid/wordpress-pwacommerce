function PWACOMMERCE_EDIT_IMAGES() {
  var JSObject = this;

  this.type = 'pwacommerce_editimages';

  this.form;
  this.DOMDoc;

  this.send_btn;
  this.deletingIcon = false;

  /**
   * Init function callled from PWACJSInterface
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

    // custom validation for FORM's inputs
    this.initValidation();
  };

  /**
   * Validate form data
   */
  this.initValidation = function() {
    // this is the object that handles the form validations
    this.validator = jQuery('#' + this.form.id, this.DOMDoc).validate({
      rules: {
        pwacommerce_editimages_icon: {
          accept: 'png|jpg|jpeg|gif'
        }
      },

      messages: {
        pwacommerce_editimages_icon: {
          accept: 'Please add a png, gif or jpeg image.'
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

    /**
     * Handle icon input
     */

    // this is a hack for chrome and safari
    var $Icon = jQuery('#' + this.type + '_icon', this.DOMDoc);
    var $RemoveIconLink = jQuery(
      '#' + this.type + '_icon_removenew',
      this.DOMDoc
    );

    $Icon.bind('change', function() {
      $Icon.focus();
      $Icon.blur();
      if (this.files[0]) jQuery('#fakefileicon').val(this.files[0].name);
      $RemoveIconLink.css('display', 'block');
    });

    $RemoveIconLink.bind('click', function() {
      jQuery('#fakefileicon').val('');

      $Icon.val('');
      jQuery(JSObject.form)
        .validate()
        .element('#' + JSObject.type + '_icon');

      $RemoveIconLink.css('display', 'none');
    });

    /**
     * Edit icon link
     */

    // attach click functions for the edit icon link
    var $EditIconLink = jQuery('.' + this.type + '_changeicon', this.DOMDoc);
    if ($EditIconLink.length > 0) {
      $EditIconLink.click(function() {
        // if the file field is hidden
        if (
          jQuery('.' + JSObject.type + '_uploadicon', JSObject.DOMDoc).css(
            'display'
          ) == 'none'
        ) {
          // reset file field value
          $Icon.val('');
          jQuery(JSObject.form)
            .validate()
            .element('#' + JSObject.type + '_icon');
          jQuery('#fakefileicon').val('');

          // hide the 'remove new icon' link
          $RemoveIconLink.css('display', 'none');

          // show upload icon field
          jQuery('.' + JSObject.type + '_uploadicon', JSObject.DOMDoc).show();

          // show cancel button
          if (
            jQuery('#' + JSObject.type + '_currenticon', JSObject.DOMDoc).attr(
              'src'
            ) != ''
          )
            jQuery(
              '.' + JSObject.type + '_changeicon_cancel',
              JSObject.DOMDoc
            ).show();

          // hide current icon
          if (
            jQuery('.' + JSObject.type + '_iconcontainer', JSObject.DOMDoc).css(
              'display'
            ) == 'block'
          )
            jQuery(
              '.' + JSObject.type + '_iconcontainer',
              JSObject.DOMDoc
            ).hide();
        }
      });
    }

    /**
     * Cancel edit icon link
     */

    // attach click functions for the cancel edit icon link
    var $CancelEditIconLink = jQuery(
      '.' + this.type + '_changeicon_cancel a',
      this.DOMDoc
    );
    if ($CancelEditIconLink.length > 0) {
      $CancelEditIconLink.click(function() {
        // if the file field is visible
        if (
          jQuery('.' + JSObject.type + '_uploadicon', JSObject.DOMDoc).css(
            'display'
          ) == 'block'
        ) {
          // reset file field value
          $Icon.val('');
          jQuery(JSObject.form)
            .validate()
            .element('#' + JSObject.type + '_icon');
          jQuery('#fakefileicon').val('');

          // hide upload icon field
          jQuery('.' + JSObject.type + '_uploadicon', JSObject.DOMDoc).hide();

          // hide cancel button
          jQuery(this)
            .parent()
            .hide();

          // display current icon (if it exists)
          if (
            jQuery('.' + JSObject.type + '_iconcontainer', JSObject.DOMDoc).css(
              'display'
            ) == 'none' &&
            jQuery('#' + JSObject.type + '_currenticon', JSObject.DOMDoc).attr(
              'src'
            ) != ''
          )
            jQuery(
              '.' + JSObject.type + '_iconcontainer',
              JSObject.DOMDoc
            ).show();
        }
      });
    }

    /**
     * Delete icon link
     */

    // attach click functions for the delete icon link
    var $DeleteIconLink = jQuery('.' + this.type + '_deleteicon', this.DOMDoc);

    if ($DeleteIconLink.length > 0) {
      var href = $DeleteIconLink.get(0).href;
      $DeleteIconLink.get(0).href = 'javascript:void(0);';

      $DeleteIconLink.click(function() {
        var isConfirmed = confirm(
          'This app icon is used when the app is added to the homescreen. Are you sure you want to remove it?'
        );

        if (isConfirmed) {
          jQuery.get(
            ajaxurl,
            {
              action: 'pwacommerce_editimages',
              type: 'delete',
              source: 'icon'
            },
            function(responseJSON) {
              var JSON = eval('(' + responseJSON + ')');
              var response = Boolean(Number(String(JSON.status)));

              JSObject.deletingIcon = false;

              if (response == true) {
                // remove image url
                jQuery(
                  '#' + JSObject.type + '_currenticon',
                  JSObject.DOMDoc
                ).attr('src', '');

                // trigger the display of the upload field
                $EditIconLink.trigger('click');

                // success message
                var message = 'The app icon has been removed.';
                PWACJSInterface.Loader.display({ message: message });
              } else {
                // error message
                var message =
                  'There was an error. Please try again in few seconds.';
                PWACJSInterface.Loader.display({ message: message });
              }
            }
          );
        }
      });
    }
  };

  /**
   * Display new image
   */
  this.displayImage = function(type, path) {
    // reset file field value
    jQuery('#' + JSObject.type + '_icon', JSObject.DOMDoc).val('');
    jQuery('#fakefileicon').val('');

    // hide upload icon field
    jQuery('.' + JSObject.type + '_uploadicon', JSObject.DOMDoc).hide();

    // hide cancel button
    jQuery('.' + JSObject.type + '_changeicon_cancel', JSObject.DOMDoc).hide();

    // add new path in the src attribute
    jQuery('#' + JSObject.type + '_currenticon', JSObject.DOMDoc).attr(
      'src',
      path
    );

    // display image container
    jQuery('.' + JSObject.type + '_iconcontainer', JSObject.DOMDoc).css(
      'display',
      'block'
    );
  };

  /**
   * Add button actions
   */
  this.addButtonsActions = function() {
    // send button
    jQuery(this.send_btn).unbind('click');
    jQuery(this.send_btn).bind('click', function() {
      JSObject.disableButton(this);
      JSObject.validate();
    });
    JSObject.enableButton(this.send_btn);

    // close button action for the inactive categories warning
    jQuery(
      '#' + JSObject.type + '_warning a.close-x',
      JSObject.DOMDoc
    ).on('click', function() {
      jQuery('#' + JSObject.type + '_warning', JSObject.DOMDoc).hide();
    });
  };

  /**
   * Enable button
   */
  this.enableButton = function(btn) {
    jQuery(btn).css('cursor', 'pointer');
    jQuery(btn).animate({ opacity: 1 }, 100);
  };

  /**
   * Disable button
   */
  this.disableButton = function(btn) {
    jQuery(btn).unbind('click');
    jQuery(btn).animate({ opacity: 0.4 }, 100);
    jQuery(btn).css('cursor', 'default');
  };

  /**
   * Scroll to first error
   */
  this.scrollToError = function(yCoord) {
    var container = jQuery('html,body', JSObject.DOMDoc);
    var scrollTop =
      parseInt(jQuery('html,body').scrollTop()) ||
      parseInt(jQuery('body').scrollTop());
    var containerHeight = container.get(0).clientHeight;
    var top = parseInt(container.offset().top);

    if (yCoord < scrollTop) {
      jQuery(container).animate({ scrollTop: yCoord - 20 }, 1000);
    } else if (yCoord > scrollTop + containerHeight) {
      jQuery(container).animate(
        { scrollTop: scrollTop + containerHeight },
        1000
      );
    }
  };

  /**
   * Validate information
   */
  this.validate = function() {
    jQuery(this.form)
      .validate()
      .form();

    // y coordinates of error inputs
    var arr_errorsYCoord = [];

    // find the y coordinate for the errors
    for (var name in this.validator.invalid) {
      var $input = jQuery(this.form[name]);
      arr_errorsYCoord.push($input.offset().top);
    }

    // if there are no errors from syntax point of view, then send data
    if (arr_errorsYCoord.length == 0) {
      this.sendData();
    } else {
      //move container(div) scroll to the first error
      arr_errorsYCoord.sort(function(a, b) {
        return a - b;
      });
      JSObject.scrollToError(arr_errorsYCoord[0]);

      // add actions to send, cancel, ... buttons. At this moment the buttons are disabled.
      JSObject.addButtonsActions();
    }
  };

  /**
   * Submit form through iframe as a target
   */
  this.submitForm = function() {
    return PWACJSInterface.AjaxUpload.dosubmit(JSObject.form, {
      onStart: JSObject.startUploadingData,
      onComplete: JSObject.completeUploadingData
    });
  };

  /**
   * Send data
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
   * Start uploading data
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
   * Complete uploading data
   */
  this.completeUploadingData = function(responseJSON) {
    jQuery('#' + JSObject.form.id, JSObject.DOMDoc).unbind('submit');
    jQuery('#' + JSObject.form.id, JSObject.DOMDoc).bind('submit', function() {
      return false;
    });

    // remove preloader
    PWACJSInterface.Preloader.remove(100);

    var JSON = eval('(' + responseJSON + ')');
    var response = Boolean(Number(String(JSON.status)));

    if (JSON.uploaded_icon != undefined)
      JSObject.displayImage('icon', JSON.uploaded_icon);

    if (response == true && JSON.messages.length == 0) {
      // show message
      var message = 'Your app has been successfully modified!';
      PWACJSInterface.Loader.display({ message: message });
    } else {
      // show messages
      if (JSON.messages.length == 0) {
        var message =
          'There was an error. Please reload the page and try again.';
        PWACJSInterface.Loader.display({ message: message });
      } else {
        for (i = 0; i < JSON.messages.length; i++)
          PWACJSInterface.Loader.display({ message: JSON.messages[i] });
      }
    }

    //enable form elements
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
