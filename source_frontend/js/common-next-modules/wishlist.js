class Wishlist {
  constructor() {
    this.ajaxParams = {
      add: {
        url: 'index.php?route=account/wishlist/add',
        method: 'post',
        responseType: 'json',
        requestHeader: {
          headerName: 'Content-Type',
          headerValue: 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        onLoad: (response) => {
          if (response['redirect']) {
            location = response['redirect'];
          }
          if (response['success']) {
            console.log('success', response);
          }
        }
      }
    };
  }

  add (product_id) {
    const sendingData = 'product_id=' + product_id;
    this.ajaxParams.add.sendingData = sendingData;
    ajaxRequest(this.ajaxParams.add);
  }
}


export default function initWishlist() {
  return new Wishlist();
}
