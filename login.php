<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SmartPhone4u Home</title>
    <link rel="stylesheet" href="css/phones.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<html>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-white fs-3" href="index.php">SmartPhone4u</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active fs-5 text-white" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-secondary fs-5" href="vendor.php">Bestellen</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">inloggen</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<header>
    <div class="container-fluid py-5 "  style="background: url('img/header.png'); background-size: cover">
        <div class="row py-5"></div>
    </div>
</header>
<body>
    <div class="container-fluid pt-5">
        <div class="container-md">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 d-flex justify-content-center align-items-center">
                    <div class="card border border-0" style="width: 25rem;">
                        <div class="card-body shadow rounded">
                            <h2>Inloggen</h2>
                            <?php if(!empty($errors['credentials'])): ?>
                                <div class="alert alert-danger">
                                    <?= $errors['credentials'] >> '' ?>
                                </div>
                            <?php endif;?>
                            <form>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">E-mailadres</label>
                                    <input type="email" class="form-control" name="email" id="mail" value="<?php echo $inputs['email'] ?? '' ?>">
                                    <div class="form-text text-danger">
                                        <?= $errors['email'] ?? '' ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Wachtwoord</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                    <div class="form-text text-danger">
                                        <?= $errors['password'] ?? '' ?>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" name="login" value="submit" class="btn btn-primary d-flex jusitfy-content-start">Login</button>
                                    <div class="d-flex justify-content-end"><a href="register.php">Registreren</a></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    session_start();
    include_once 'modules/database.php';
    include_once 'modules/functions.php';

    $errors = [];
    $inputs = [];

    const EMAIL_REQUIRED = 'Email invullen';
    const EMAIL_INVALID = 'Geldig email adres invullen';
    const PASSWORD_REQUIRED = 'Password invullen';
    const CREDENTIALS_NOT_VALID = 'Verkeerde email en/of wachtwoord ingevuld';

// Email sanitize & validate email
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($email===false) {
        //Validate email
        $errors['email'] = EMAIL_REQUIRED;
    } else {
        $inputs['email'] = EMAIL_INVALID;
    }

    //Validate password
$password = filter_input(INPUT_POST, 'password');

if(empty($password)) {
    $errors['password'] = PASSWORD_REQUIRED;
}   else {
    $inputs['password'] = $password;
}

if (count($errors) === 0) {
    //Var dump ($result)
    switch($result) {
        case 'ADMIN':
            header("location: admin.php");
            break;
        case 'FAILURE':
            $errors['credentials'] = CREDENTIALS_NOT_VALID;
            include_once "login.php";
            break;
    }
}
?>