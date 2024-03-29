<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container-fluid py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-4 mb-3">
        <div class="card rounded" id="newUserCard">
          <div class="card-header">
            <h3>New User Today</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 mb-3">
        <div class="card rounded" id="subscriberCard">
          <div class="card-header">
            <h3>Subscriber Today</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 mb-3">
        <div class="card rounded" id="feedbackCard">
          <div class="card-header">
            <h3>FeedBack Today</h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card for displaying tables -->
  <div class="container mt-4">
    <div class="card rounded">
      <div class="card-header">
        <h3>Details List</h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody id="table-body">
              <!-- Dummy data for the table -->
              <!-- New User Today -->
              <tr id="newUserTable" style="display: none;">
                <td>1</td>
                <td>John Doe</td>
                <td>johndoe@example.com</td>
              </tr>
              <!-- Subscriber Today -->
              <tr id="subscriberTable" style="display: none;">
                <td>2</td>
                <td>Jane Smith</td>
                <td>janesmith@example.com</td>
              </tr>
              <!-- FeedBack Today -->
              <tr id="feedbackTable" style="display: none;">
                <td>3</td>
                <td>Adam Johnson</td>
                <td>adamjohnson@example.com</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    // Click event for "New User Today" card
    $('#newUserCard').click(function () {
      $('#table-body tr').hide(); // Hide all table rows
      $('#newUserTable').show(); // Show specific table row
    });

    // Click event for "Subscriber Today" card
    $('#subscriberCard').click(function () {
      $('#table-body tr').hide(); // Hide all table rows
      $('#subscriberTable').show(); // Show specific table row
    });

    // Click event for "FeedBack Today" card
    $('#feedbackCard').click(function () {
      $('#table-body tr').hide(); // Hide all table rows
      $('#feedbackTable').show(); // Show specific table row
    });
  });
</script>


  
  
  

</div>