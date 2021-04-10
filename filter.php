<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <title>Reviews</title>
</head>
<body>
   <div class="container mt-4">
      <div class="row d-flex justify-content-around">
         <div class="col-lg-8">
            <h2>Reviews</h3>
            <table class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th scope="col">#</th>
                     <th scope="col">Text</th>
                     <th scope="col">Rating</th>
                     <th scope="col">Date</th>
                  </tr>
               </thead>
               <tbody>

               <?php 
               
                  $reviews = json_decode(file_get_contents("reviews.json"), false);
                 
                  foreach($reviews as $key => $value){
                     $key = $key + 1;
                     echo '<tr>';
                        echo '<th>'.$key.'</th>';
                        echo '<td>'.$value->reviewText.'</td>';
                        echo '<td>'.$value->rating.'</td>';
                        echo '<td>'.$value->reviewCreatedOnDate.'</td>';
                     echo '</tr>';
                  }

               ?>
                 
               </tbody>
            </table>
            <br>
            
         

         </div>

         <div class="col-md-3">
            <h3>Filter Reviews</h3>
            <form method="POST" class="mw-5">
      
               <div class="form-group">
                  <label for="rating">Order by rating:</label><br>
                  <select class="form-control" name="rating" id="rating">
                     <option value="Highest First">Highest First</option>
                     <option value="Lowest First">Lowest First</option>
                  </select>
               </div>
      
               <div class="form-group">
                  <label for="min">Minimum rating:</label><br>
                  <select class="form-control" name="min" id="min">
                     <option value="5">5</option>
                     <option value="4">4</option>
                     <option value="3">3</option>
                     <option value="2">2</option>
                     <option value="1">1</option>
                  </select>
               </div>
      
               <div class="form-group">
                  <label for="date">Order by date:</label><br>
                  <select class="form-control" name="date" id="date">
                     <option value="Newest First">Newest First</option>
                     <option value="Oldest First">Oldest First</option>
                  </select>
                  
               </div>
               
               <div class="form-group">
                  <label for="text">Prioritize by text:</label><br>
                  <select class="form-control" name="text" id="text">
                     <option value="Yes">Yes</option>
                     <option value="No">No</option>
                  </select>
               </div>
      
               <input type="submit" value="Filter" class="btn btn-primary">
               <?php 
                  $rating = $_POST['rating'];
                  $min = $_POST['min'];
                  $date = $_POST['date'];
                  $text = $_POST['text'];
                  $msg = "Rating: ".$rating." Min: ".$min." Date: ".$date." Text: ".$text." ";
                  echo $msg;
               ?>
            </form>
         </div>

      </div>
      <br>
   </div>


   
</body>
</html>