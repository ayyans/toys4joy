// setup csrf token as default
$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

// play notification sound on new order
const time = new Date().toLocaleString('en-US', {timeZone: "Asia/Qatar"});
let newOrdersCount = 0;
const checkForNewOrder = time => {
  fetch(checkForNewOrderUrl, {
    method: 'post',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ time })
  })
  .then(res => res.json())
  .then(res => {
    if (res.count !== newOrdersCount) {
      new Audio(notificationSound).play()
      .then(() => {
        newOrdersCount = res.count;
        toastr.info('You have received a new order');
      })
      .catch(err => {
        toastr.warning('Please interact with the browser to play notification sound');
        console.log(err);
      });
    }
  })
  .catch(err => console.log(err));
}
// setting new order check intervel
setInterval(() => checkForNewOrder(time), 5000);