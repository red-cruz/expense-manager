export function closeModal(modalId) {
  document
    .getElementById(modalId)
    .querySelector('[data-bs-dismiss="modal"]')
    .dispatchEvent(new Event('click'));
}
