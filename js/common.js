
// https://www.w3schools.com/howto/howto_js_scroll_to_top.asp
// When the user scrolls down a certain height from the top of the document, show the button
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
  const scrollLimit = 20;
  let scrollToTopBtn = document.getElementById("scrollToTopBtn");
  if (document.body.scrollTop > scrollLimit || document.documentElement.scrollTop > scrollLimit) {
    scrollToTopBtn.style.display = "block";
  } else {
    scrollToTopBtn.style.display = "none";
  }
}
// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

function updateNotificationsCounter() {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // let old_num_notifs = parseInt(document.getElementById("notification_counter").innerHTML);
        let num_notifs = parseInt(this.responseText);
        document.getElementById("notification_counter").innerHTML = num_notifs;
        if (num_notifs > 0) {
            document.getElementById("notification_counter").style.fontWeight = "bold";
            document.getElementById("notification_counter").classList.add("bg-danger");
            document.getElementById("notification_counter").classList.remove("bg-secondary");
            // if (num_notifs > old_num_notifs) {
            //     alert("Hai una nuova notifica");
            // }
        } else {
            document.getElementById("notification_counter").style.fontWeight = "normal";
            document.getElementById("notification_counter").classList.add("bg-secondary");
            document.getElementById("notification_counter").classList.remove("bg-danger");
        }
      }
    };
    xmlhttp.open("GET", "php/get-num-notifs.php", true);
    xmlhttp.send();
}

updateNotificationsCounter();
setInterval(updateNotificationsCounter, 5000);
