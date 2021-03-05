'use strict';


// * SEARCH URL PARAMETER VALUE
export function getURLVar(key) {
  const currentURL = String(document.location);
  const urlAddress = new URL(currentURL);
  const result = urlAddress.searchParams.get(key);
  return (result) ? result : '';
}
