<?php
    //global variables
    //$_GET
    //$_POST
    //$_REQUEST
    //$_SERVER >>常需要SERVER_NAME , REQUEST_METHOD , REQUES_URI

    $database = new PDO(
        'mysql:host=devkinsta_db;
        dbname=Classroom_Management',
        'root',
        '4JqGyoVdUoAAEJxU'
    );

    $query = $database->prepare('SELECT * FROM Students');
    $query-> execute();

    $students = $query->fetchAll();

    if(
        $_SERVER['REQUEST_METHOD'] === 'POST'
    ){
        if ($_POST['action']==='add')
        {
            //add student
            $statement = $database -> prepare(
                "INSERT INTO Students (`name`) 
                VALUES (:name)"
            );
            $statement -> execute([
                'name' => $_POST['student']
            ]);
    
            header('Location:/');
            exit;
        }

        if ($_POST['action'] === 'delete')
        {
            //delete stuudent
            $statement = $database->prepare(
                'DELETE FROM Students WHERE id = :id'
            );

            $statement->execute([
                'id' => $_POST['student_id']
            ]);

            header('Location:/');
            exit;
        }

    }

    // var_dump($students);
?>
<!-- ============================================================ -->
<!DOCTYPE html>
<html>
  <head>
    <title>Classroom Management</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
    />
    <style type="text/css">
      body {
        background: #f1f1f1;
      }
    </style>
  </head>
  <body>
    <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
      <div class="card-body">
        <h3 class="card-title mb-3">My Classroom</h3>
        <div >
            <!-- add new form -->
        <form method="POST" 
        action="<?php echo $_SERVER['REQUEST_URI'] ?>" 
        class="mt-4 d-flex justify-content-between align-items-center">
            <input
            type="text"
            class="form-control"
            placeholder="Add new student..."
            name="student"
            required
          />
          <input 
          type="hidden" 
          name="action" 
          value="add"
          >
          <button class="btn btn-primary btn-sm rounded ms-2">Add</button>
        </form>
        </div>
      </div>
    </div>


    <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
      <div class="card-body">
        <h3 class="card-title mb-3">Students</h3>
        <div class="mt-4">
            <!-- delete form -->
            <?php foreach ($students as $student): ?>
                <div class="d-flex justify-content-between gap-3">
                    <?php echo $student['name']; ?>
                        <form 
                            action="<?php echo $_SERVER
                            ['REQUEST_URI']; ?>" 
                            method="POST">
                            <input 
                                type="hidden" 
                                name="student_id" 
                                value="<?php echo $student ['id']; ?>"
                                >
                            <input 
                                type="hidden" 
                                name="action" 
                                value="delete"
                                >
                            <button class="btn btn-danger mb-1">Delete</button>
                        </form>
                 </div>
            <?php endforeach; ?>
        </div>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
