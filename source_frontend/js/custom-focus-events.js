'use strict';

// События focusEnter и focusLeave - аналоги mouseEnter и mouseLeave


function appendCustomFocusEvents(containerElement) {

  let focusInside = false;

  function _onContainerFocusIn() {
    if (!focusInside) {
      containerElement.dispatchEvent(new CustomEvent('focusEnter'));
      focusInside = true;
    }
  }

  function _onContainerFocusOut(evt) {
    if (!containerElement.contains(evt.relatedTarget)) {
      containerElement.dispatchEvent(new CustomEvent('focusLeave', {
        // bubbles: true,
        detail: {
          relatedTarget: evt.relatedTarget
        }
      }));
      focusInside = false;
    }
  }

  // в старой версии использовалось отложенный focusout
  // function _onContainerFocusOut() {
  //   if (!containerElement.contains(document.activeElement)) {
  //     containerElement.dispatchEvent(new CustomEvent('focusLeave', {bubbles: true}));
  //     focusInside = false;
  //   }
  // }

  if (!containerElement.customFocusEventsIsAdded) {
    containerElement.addEventListener('focusin', _onContainerFocusIn);
    containerElement.addEventListener('focusout', _onContainerFocusOut);
    containerElement.customFocusEventsIsAdded = true;
    // containerElement.addEventListener('focusout', (evt) => {
    //   setTimeout(_onContainerFocusOut, 0);
    // });
  }
}


export default appendCustomFocusEvents;
