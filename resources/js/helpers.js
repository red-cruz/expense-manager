import Noty from 'noty';

export function closeModal(modalId) {
  document
    .getElementById(modalId)
    .querySelector('[data-bs-dismiss="modal"]')
    .dispatchEvent(new Event('click'));
}

export function notify(config) {
  new Noty({
    ...{
      theme: 'bootstrap-v4',
      layout: 'bottomRight',
      type: 'success',
      timeout: 3000,
    },
    ...config,
  }).show();
}
