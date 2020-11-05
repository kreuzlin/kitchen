</div>
  <!-- jQuery -->
  <script type="text/javascript" src="https://saram.linard.org/js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="https://saram.linard.org/js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="https://saram.linard.org/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="https://saram.linard.org/js/mdb.min.js"></script>
  <!-- Your custom scripts (optional) -->
  <script type="text/javascript"></script>
  <!-- MDBootstrap Datatables  -->
  <script type="text/javascript" src="https://saram.linard.org/js/addons/datatables.min.js"></script>
  <script>
    $(document).ready(function () {
    $('#dtBasicTab').DataTable({
      "aaSorting": [],
      columnDefs: [{
      orderable: false,
      targets: [0,1]
      }]
      
    });
      $('.dataTables_length').addClass('bs-select');
    });
  </script>
  <script>
  function updConcept(str, buttonID) {
    var xhr = new XMLHttpRequest();
    //console.log(str)
    xhr.open("POST", '<?php echo URLROOT . '/assessments/update/'; ?>', true);

    //Send the proper header information along with the request
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() { // Call a function when the state changes.
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Request finished. Do processing here.
            //alert(this.responseText);
        }
    }
    xhr.send("content=" + str + "&AID=" + document.getElementById('aid').value + "&ID=" + buttonID)
  }
</script>
<script>
$(document).ready(function() {
  $('input[type=radio]').change(function() {
    //alert($(this).val()); // or this.value
    statusID = this.name;
    statusID = statusID.replace("status[", ""); // extract the number out of a term e.g. status[512]
    statusID = statusID.replace("]", ""); // extract the number out of a term e.g. status[512]
    console.log(statusID)
    statusValue = this.value;
    var xhr = new XMLHttpRequest();
    //console.log(str)
    xhr.open("POST", '<?php echo URLROOT . '/assessments/update/'; ?>', true);

    //Send the proper header information along with the request
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() { // Call a function when the state changes.
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        // Request finished. Do processing here.
        
        myselector = 'label[for="';
        myselector += 'textarea' + statusID + '"]';
        //alert(myselector);
        //alert(document.querySelector(myselector).getAttribute("for"));
        //alert(document.querySelector(myselector).innerHTML);

        switch(statusValue) {
          case "open":
            newlabel = document.getElementById('textOpen').innerHTML;
            document.querySelector(myselector).innerHTML = newlabel;
            break;
          case "n/a":
            newlabel = document.getElementById('textNA').innerHTML;
            document.querySelector(myselector).innerHTML = newlabel;
            break;
          case "ok":
            newlabel = document.getElementById('textOK').innerHTML;
            document.querySelector(myselector).innerHTML = newlabel;
            break;
          case "gap":
            newlabel = document.getElementById('textGap').innerHTML;
            document.querySelector(myselector).innerHTML = newlabel;
            break;  
          default:
          alert("error");
        }
      }
    }
    xhr.send("reqStatus=" + statusValue + "&AID=" + document.getElementById('aid').value + "&ID=" + statusID)

  });
});
</script>

</body>
</html>