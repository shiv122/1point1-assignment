/* eslint-disable no-unused-expressions */
/* eslint-disable no-undef */
import $ from 'jquery';

toastr.options = {
  closeButton: true,
  showMethod: 'slideDown'
};

export const blockUI = ({ selector = 'body', message = null }) => {
  $(selector).block({
    message:
      message ??
      '<div class="sk-wave mx-auto"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div>',
    css: {
      backgroundColor: 'transparent',
      border: '0'
    },
    overlayCSS: {
      opacity: 0.5
    }
  });
};

export const rebound = async ({
  form = null,
  data = null,
  method = 'POST',
  route = null,
  refresh = false,
  reset = true,
  reload = false,
  redirect = null,
  block = 'body',
  blockMessage = null,
  notification = true,
  logging = true,
  returnData = false,
  processData = false,
  appendData = false,
  contentType = 'application/x-www-form-urlencoded'
}) => {
  if (form === null && data === null) {
    throw new Error('No form or data provided in rebound()');
  }
  if (route === null) {
    throw new Error('No url provided in rebound()');
  }
  let form_data;
  if (form !== null) {
    const formData = $(form)[0];
    form_data = new FormData(formData);
  }

  if (appendData) {
    for (const key in appendData) {
      form_data.append(key, appendData[key]);
    }
  }
  if (block) {
    blockUI({ selector: block, message: blockMessage });
  }
  const btn = $(form).find('button[type=submit]');
  const btnText = $(btn).text();

  if (btn) {
    $(btn).attr('disabled', true);
    $(btn).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
  }

  let statusCode;
  let errors = false;

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  const response = await $.ajax({
    url: route,
    method: method,
    data: data ?? form_data,
    processData: processData,
    contentType: processData ? contentType : false,
    success: function (response, status, xhr) {
      if (notification) {
        toastr.success(response.message ?? 'Success');
      }
      if (reload) {
        window.location.reload();
      }

      if (redirect !== null || (response.redirect !== null && response.redirect !== undefined)) {
        window.location.href = redirect ?? response.redirect;
      }

      if (response.refresh_table) {
        $('#table-refresh').click();
      }

      if (refresh || response.refresh) {
        window.location.reload();
      }
      if (reset) {
        if (form) {
          $(form).trigger('reset');
          $(form)
            .find('input')
            .each(function () {
              $(this).val('').trigger('change');
            });
        }
      }
      return response;
    },
    error: function (xhr, status, error) {
      if (xhr.status === 422) {
        let focused = false;
        $.each(xhr.responseJSON.errors, function (key, value) {
          toastr.error(value);

          if (form && !focused) {
            $(form).find(`[name="${key}"]`).focus();
            focused = true;
          }

          if (logging) {
            console.error(key, value);
          }
        });
      } else {
        if (xhr.responseJSON?.message) {
          toastr.error(xhr.responseJSON.message);
        } else {
          toastr.error('Something went wrong');
        }
      }
    },
    complete: function (xhr, status) {
      if (btn) {
        $(btn).attr('disabled', false);
        $(btn).html(btnText);
      }
      block ? $(block).unblock() : null;
      statusCode = xhr.status;
    }
  });

  console.log(response);

  return { ...response, statusCode: statusCode };
};

$(document).on('click', '[data-action-preview]', function (e) {
  e.preventDefault();
  const image = $(this).attr('src');
  $('#__image-previewer img').attr('src', image);
  $('#__image-previewer').modal('show');
});

$(document).on('click', '[data-edit]', async function () {
  const route = $(this).data('edit');
  const modal = $(this).data('modal');
  const callback = $(this).data('callback');

  const data = await rebound({
    data: '',
    method: 'get',
    route: route,
    notification: false,
    loader: '<div class="fetch"><span class="loader"></span></div>'
  }).catch(error => {
    console.log(error);
  });

  if (data.statusCode === 200) {
    if (typeof window[callback] == 'function') {
      console.log(callback);
      eval(callback)(data, modal);
    } else {
      toastr.error('Callback undefined', 'No callback function defined for edit action.');
    }
  }
});
