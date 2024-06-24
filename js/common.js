
function updateNotificationsCounter() {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // let old_num_notifs = parseInt(document.getElementById("notification_counter").innerHTML);
        let num_notifs = parseInt(this.responseText);
        document.getElementById("notification_counter").innerHTML = num_notifs;
        if (num_notifs > 0) {
            document.getElementById("notification_counter").style.color = "red";
            // if (num_notifs > old_num_notifs) {
            //     alert("Hai una nuova notifica");
            // }
        } else {
            document.getElementById("notification_counter").style.color = "black";
        }
      }
    };
    xmlhttp.open("GET", "php/get-num-notifs.php", true);
    xmlhttp.send();
}

updateNotificationsCounter();
setInterval(updateNotificationsCounter, 5000);
