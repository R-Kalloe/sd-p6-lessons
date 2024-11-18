<?php
function getVendors():array
{
    global $pdo;
    $categories = $pdo->query('SELECT * FROM vendor')->fetchAll(PDO::FETCH_CLASS, 'Vendor');
    return $categories;
}

function getVendorName(int $id):string
{
    global $pdo;
    $sth = $pdo->prepare('SELECT * FROM vendor WHERE id= ? ');
    $sth->bindParam(1, $id, PDO::PARAM_INT);
    $sth->setFetchMode(PDO::FETCH_CLASS, Vendor::class);
    $sth->execute();
    $category = $sth->fetch();
    return $category->name;
}

function getSmartphoneName(int $id):string
{
    global $pdo;
    $sth = $pdo->prepare('SELECT * FROM smartphone WHERE id= ? ');
    $sth->bindParam(1, $id, PDO::PARAM_INT);
    $sth->setFetchMode(PDO::FETCH_CLASS, Smartphone::class);
    $sth->execute();
    $p = $sth->fetch();
    return $p->name;
}

function getSmartphones(int $vendorId):array
{
    global $pdo;
    $sth = $pdo->prepare('SELECT * FROM smartphone WHERE vendor_id=? ');
    $sth->bindParam(1, $vendorId);
    $sth->execute();
    return $sth->fetchAll(PDO::FETCH_CLASS, 'Smartphone');
}

function getSmartphone(int $id):object
{
    global $pdo;
    $sth = $pdo->prepare('SELECT * FROM smartphone WHERE id=? ');
    $sth->bindParam(1, $id);
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_CLASS, 'Smartphone');
    return $sth->fetch();
}

function getVendorId(int $smartphone_id):string
{
    global $pdo;
    $sth = $pdo->prepare('SELECT * FROM smartphone WHERE id=? ');
    $sth->bindParam(1, $smartphone_id, PDO::PARAM_INT);
    $sth->setFetchMode(PDO::FETCH_CLASS, Smartphone::class);
    $sth->execute();
    $smartphone= $sth->fetch();
    return $smartphone->vendor_id;
}

function getVendorNameFromProductId($id)
{
    global $pdo;
    $sth = $pdo->prepare('SELECT v.name FROM smartphone as s JOIN vendor as v WHERE s.vendor_id= v.id AND s.id=? ');
    $sth->bindParam(1, $id, PDO::PARAM_INT);
    $sth->setFetchMode(PDO::FETCH_CLASS, Vendor::class);
    $sth->execute();
    $vendor= $sth->fetch();
    //var_dump($smartphone->name);
    return $vendor->name;
}


function savePurchase(array $inputs):bool
{
    global $pdo;

    $sth = $pdo->prepare('INSERT INTO purchase  (fname,lname,email,address,zipcode,city,date,smartphone_id) VALUES (?,?,?,?,?,?,NOW(),?)');
    $sth->bindParam(1, $inputs['fname']);
    $sth->bindParam(2, $inputs['lname']);
    $sth->bindParam(3,$inputs['email']);
    $sth->bindParam(4, $inputs['address']);
    $sth->bindParam(5, $inputs['zipcode']);
    $sth->bindParam(6, $inputs['city']);
    $sth->bindParam(7, $_GET['id']);

    return $sth->execute();
}

function checkLogin($inputs):string
{
    global $pdo;

    $sql = 'SELECT * FROM user WHERE `email` = :e';
    $sth = $pdo->prepare($sql);
    $sth->bindParam(':e', $inputs['email']);
    $sth->setFetchMode(PDO::FETCH_ASSOC, 'User');
    $sth->execute();
    $user = $sth->fetch();
    var_dump($user);

    //$user=false, verkeerde password/username, anders $user = object
    if($user!==false) {
        $_SESSION['user']=$user;
        if($_SESSION['user']->role=='admin')
        {
            return 'ADMIN';
        }
    }
    return 'FAILURE';
}




