<?php

session_start();
ob_start();

date_default_timezone_set('America/Sao_Paulo');

//use Psr\Http\Message\ResponseInterface as Response;
//use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

use \app\database\Sql;



require 'vendor/autoload.php';


function convert_date_to_db_type($origDate){
	//convert date from dd/mm/yyyy to yyyy-mm-dd


  $date = str_replace('/', '-', $origDate );
  $newDate = date("Y-m-d", strtotime($date));
  return $newDate;
}

function convert_date_to_brazilian_format($origDate){
  //input  YYYY-MM-DD e output DD/MM/YYYY 


  $date = str_replace('-', '/', $origDate );
  $newDate = date("d/m/Y", strtotime($date));
  return $newDate;
}




// Create App
$app = AppFactory::create();

// Create Twig
//$twig = Twig::create('../app/views/site', ['cache' => '../app/views-cache']);

$twig = Twig::create('app/views/site', [
    //'cache' => false
	'cache' => 'app/views-cache'
]);


// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

// Define named route
$app->get('/', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $view = Twig::fromRequest($request);
    return $view->render($response, 'home.html', [
		"user_name"=> $user_name
    ]);
});



/*
1- groups
*/

//----------------------------------------------
// list all products
//listar grupos de produtos
$app->get('/groups', function ($request, $response, $args) {

    if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
 
    $groups = $sql->select("select * from product_group");
 
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'groups.html', [
             "groups" => $groups
			// "user_name"=> $user_name
 
     ]);
 });
 // create group
 $app->get('/groups/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


 
    $view = Twig::fromRequest($request);

    return $view->render($response, 'groups-create.html', [
		"user_name"=> $user_name
    ]);
}); 
//save new group

$app->post('/groups/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();

	 $sql->select("insert into product_group(name) values(:name)", array(
		":name"=>$_POST['name']	
	));

    
    header("Location: /groups");
	exit;

});
// update group

$app->get('/groups/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();

    $groups = $sql->select("select * from product_group
	  where id=:id", array(
		":id"=>$args['id']	
	));
 
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'groups-update.html', [
             "groups" => $groups,
			 "user_name"=> $user_name
 
     ]);
 });
//save update group

//salva o update
$app->post('/groups/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();

     $sql->select("update product_group
     set name=:name
	  where id=:id", array(
        ":name"=>$_POST['name'],
		":id"=>$args['id']	
	));

    
    header("Location: /groups");
	exit;
});
// delete

$app->get('/groups/{id}/delete', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();

    $sql->select("delete  from product_group
    where id=:id", array(
      ":id"=>$args['id'] 
    ));
    
    header("Location: /groups");
	exit;
 });

 //----------------------- PRODUCTS ------------------------
 //list products

 $app->get('/products', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
 
    $products = $sql->select("select * from products");
 
     $view = Twig::fromRequest($request);
 
     return $view->render($response, 'products.html', [
    
             "products" => $products,
			 "user_name"=> $user_name
 
     ]);
 });

 //create
 
$app->get('/products/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    //in the product register it is necessary to 
    //list the groups so that the user can choose one.
    
    $sql = new Sql();

	$groups = $sql->select("SELECT * FROM product_group order by name desc ");


    $view = Twig::fromRequest($request);

    return $view->render($response, 'products-create.html', [

        "groups" => $groups,
		"user_name"=> $user_name
   
    ]);
});
// save create product

$app->post('/products/create', function ($request, $response, $args) {
    
	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];





    // we need to  replace comma with dot


    // $_POST["stock"] =  str_replace(",",".", $_POST["stock"] );
    // $_POST["stock_min"] =  str_replace(",",".", $_POST["stock_min"] );
    // $_POST["purchase_price"] =  str_replace(",",".", $_POST["purchase_price"] );
    // $_POST["sale_price"] =  str_replace(",",".", $_POST["sale_price"] );
    

    $sql = new Sql();
     
    $results = $sql->select("insert into products(reference,name,id_group,
	stock,stock_min,purchase_price,sale_price,expiration_date,unit,bar_code,note)
	values (:reference,:name,:id_group,
	:stock,:stock_min,:purchase_price,:sale_price,:expiration_date,:unit,:bar_code,:note) ",
	  array(


		":reference"=>$_POST["reference"],
		":name"=>$_POST["name"],
		":id_group"=>$_POST["id_group"],
		":stock"=>$_POST["stock"],
		":stock_min"=>$_POST["stock_min"],
		":purchase_price"=>$_POST["purchase_price"],
		":sale_price"=>$_POST["sale_price"],
		":expiration_date"=>$_POST["expiration_date"],
		":unit"=>$_POST["unit"],
		":bar_code"=>$_POST["bar_code"],
		":note"=>$_POST["note"]
		 
	 ));


    
    header("Location: /products");
	exit;

});

// update product

$app->get('/products/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();


    $groups = $sql->select("SELECT * FROM product_group order by name desc ");


    $sql2 = new Sql();



    $product = $sql2->select("select 
    
    p.id as id,
	p.id_group as id_group,
	gp.name as group_name,
	p.name as name,
	p.reference as reference,
	p.stock as stock,
	p.stock_min as stock_min,
	p.purchase_price as purchase_price,
	p.sale_price as sale_price,
	p.expiration_date as expiration_date,
	p.unit as unit,
	p.bar_code as bar_code,
	p.note as note 
	from products p, product_group gp
	where (p.id_group = gp.id)
	and p.id =:id", array(
		":id"=>$args['id']	
	));
 
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'products-update.html', [
    
             "product" => $product[0],
             "groups"=> $groups,
			 "user_name"=> $user_name
 
     ]);
 });
//save update

$app->post('/products/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();

    
    $product_update = $sql->select("update products
    set reference=:reference,
    name=:name,
    id_group=:id_group,
    stock=:stock,
    stock_min=:stock_min,
    purchase_price=:purchase_price,
    sale_price=:sale_price,
    expiration_date=:expiration_date,
    unit=:unit,
    bar_code=:bar_code,
    note=:note
     where id=:id" , array(
        ":reference"=>$_POST["reference"],
		":name"=>$_POST["name"],
		":id_group"=>$_POST["id_group"],
		":stock"=>$_POST["stock"],
		":stock_min"=>$_POST["stock_min"],
		":purchase_price"=>$_POST["purchase_price"],
		":sale_price"=>$_POST["sale_price"],
		":expiration_date"=>$_POST["expiration_date"],
		":unit"=>$_POST["unit"],
		":bar_code"=>$_POST["bar_code"],
		":note"=>$_POST["note"],
		":id"=>$args['id']
	));

    
    header("Location: /products");
	exit;
});

//delete

$app->get('/products/{id}/delete', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();


    $sql->select("delete from products
    where id=:id", array(
      ":id"=>$args['id'] 
    ));
  
    header("Location: /products");
	exit;
 
 });
//----------------------- CLIENTS ------------------------
 //list clients
 $app->get('/clients', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
 
    $clients = $sql->select("select * from clients");
 
     $view = Twig::fromRequest($request);
 
     return $view->render($response, 'clients.html', [
    
             "clients" => $clients,
			 "user_name"=> $user_name
     ]);
 });
 
 // create
$app->get('/clients/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


 
    $view = Twig::fromRequest($request);

    return $view->render($response, 'clients-create.html', [
		"user_name"=> $user_name
    ]);
});

// save create
$app->post('/clients/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
    
    $sql->select("insert into clients(name,cnpj_cpf,ie,phone,
	cell_phone,email,address,number,complement,district,city,state,zip_code)
	values (:name,:cnpj_cpf,:ie,:phone,:cell_phone,:email,:address,:number,:complement,:district,:city,:state,:zip_code) ",
	  array(

		":name"=>$_POST["name"],
		":cnpj_cpf"=>$_POST["cnpj_cpf"],
		":ie"=>$_POST["ie"],
		":phone"=>$_POST["phone"],
		":cell_phone"=>$_POST["cell_phone"],
		":email"=>$_POST["email"],
		":address"=>$_POST["address"],
		":number"=>$_POST["number"],
		":complement"=>$_POST["complement"],
		":district"=>$_POST["district"],
		":city"=>$_POST["city"],
		":state"=>$_POST["state"],
		":zip_code"=>$_POST["zip_code"]
		 
	 ));

    
    header("Location: /clients");
	exit;

});

//  update
$app->get('/clients/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();

    $client = $sql->select("select * from clients
	  where id=:id", array(
		":id"=>$args['id']	
	));
 
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'clients-update.html', [

             "client" => $client[0],
			 "user_name"=> $user_name
 
     ]);
 });
//save update
$app->post('/clients/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
    
    $sql->select("update clients set name=:name,cnpj_cpf=:cnpj_cpf,ie=:ie,phone=:phone,
	cell_phone=:cell_phone,email=:email,address=:address,number=:number,complement=:complement,
	district=:district,city=:city,state=:state,zip_code=:zip_code where id=:id",
	  array(

		":name"=>$_POST["name"],
		":cnpj_cpf"=>$_POST["cnpj_cpf"],
		":ie"=>$_POST["ie"],
		":phone"=>$_POST["phone"],
		":cell_phone"=>$_POST["cell_phone"],
		":email"=>$_POST["email"],
		":address"=>$_POST["address"],
		":number"=>$_POST["number"],
		":complement"=>$_POST["complement"],
		":district"=>$_POST["district"],
		":city"=>$_POST["city"],
		":state"=>$_POST["state"],
		":zip_code"=>$_POST["zip_code"],
		":id"=>$args['id']	
	 ));

    
    header("Location: /clients");
	exit;
});
//delete
$app->get('/clients/{id}/delete', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();


     $sql->select("delete  from clients
    where id=:id", array(
      ":id"=>$args['id'] 
    ));
  
    header("Location: /clients");
	exit;
 
 });

 //----------------------- SUPPLIERS  ------------------------
 //list
 $app->get('/suppliers', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
 
    $suppliers = $sql->select("select * from suppliers");
 
     $view = Twig::fromRequest($request);
 
     return $view->render($response, 'suppliers.html', [
    
             "suppliers" => $suppliers,
			 "user_name"=> $user_name
     ]);
 });

 // create
$app->get('/suppliers/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


 
    $view = Twig::fromRequest($request);

    return $view->render($response, 'suppliers-create.html', [
		"user_name"=> $user_name
    ]);
});


// save create
$app->post('/suppliers/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
    
    $sql->select("insert into suppliers(name,cnpj_cpf,ie,phone,
	cell_phone,email,address,number,complement,district,city,state,zip_code)
	values (:name,:cnpj_cpf,:ie,:phone,:cell_phone,:email,:address,:number,:complement,:district,:city,:state,:zip_code) ",
	  array(

		":name"=>$_POST["name"],
		":cnpj_cpf"=>$_POST["cnpj_cpf"],
		":ie"=>$_POST["ie"],
		":phone"=>$_POST["phone"],
		":cell_phone"=>$_POST["cell_phone"],
		":email"=>$_POST["email"],
		":address"=>$_POST["address"],
		":number"=>$_POST["number"],
		":complement"=>$_POST["complement"],
		":district"=>$_POST["district"],
		":city"=>$_POST["city"],
		":state"=>$_POST["state"],
		":zip_code"=>$_POST["zip_code"]
		 
	 ));

    
    header("Location: /suppliers");
	exit;

});

//  update
$app->get('/suppliers/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();

    $supplier = $sql->select("select * from suppliers
	  where id=:id", array(
		":id"=>$args['id']	
	));
 
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'suppliers-update.html', [

             "supplier" => $supplier[0],
			 "user_name"=> $user_name
 
     ]);
 });
//save update
$app->post('/suppliers/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
    
    $sql->select("update suppliers set name=:name,cnpj_cpf=:cnpj_cpf,ie=:ie,phone=:phone,
	cell_phone=:cell_phone,email=:email,address=:address,number=:number,complement=:complement,
	district=:district,city=:city,state=:state,zip_code=:zip_code where id=:id",
	  array(

		":name"=>$_POST["name"],
		":cnpj_cpf"=>$_POST["cnpj_cpf"],
		":ie"=>$_POST["ie"],
		":phone"=>$_POST["phone"],
		":cell_phone"=>$_POST["cell_phone"],
		":email"=>$_POST["email"],
		":address"=>$_POST["address"],
		":number"=>$_POST["number"],
		":complement"=>$_POST["complement"],
		":district"=>$_POST["district"],
		":city"=>$_POST["city"],
		":state"=>$_POST["state"],
		":zip_code"=>$_POST["zip_code"],
		":id"=>$args['id']	
	 ));

    
    header("Location: /suppliers");
	exit;
});

//delete
$app->get('/suppliers/{id}/delete', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();


     $sql->select("delete  from suppliers
    where id=:id", array(
      ":id"=>$args['id'] 
    ));
  
    header("Location: /suppliers");
	exit;
 
 });

//----------------------- PAYMENT METHOD ------------------------
 //list
$app->get('/paymentmethods', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];

    $sql = new Sql();
 
    $payment_methods = $sql->select("select * from payment_methods");
 
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'paymentmethods.html', [
   
             "payment_methods" => $payment_methods,
			 "user_name"=> $user_name

 
     ]);
 });
 
 // create
$app->get('/paymentmethods/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


 
    $view = Twig::fromRequest($request);

    return $view->render($response, 'paymentmethods-create.html', [

		"user_name"=> $user_name
   
    ]);
});

// create save
$app->post('/paymentmethods/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];



    $sql = new Sql();

	 $sql->select("insert into
	 payment_methods(name) values(:name)", array(
		":name"=>$_POST['name']
	
	));

    header("Location: /paymentmethods");
	exit;

});

// update
$app->get('/paymentmethods/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];

    $sql = new Sql();

    $paymentmethods = $sql->select("select * from payment_methods
	  where id=:id", array(
		":id"=>$args['id']	
	));
 
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'paymentmethods-update.html', [
    
             "paymentmethods" => $paymentmethods[0],
			 "user_name"=> $user_name
 
     ]);
 });

//save update
$app->post('/paymentmethods/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();

    $sql->select("update payment_methods set
     name=:name where id=:id", array(
        ":name"=>$_POST['name'],
		":id"=>$args['id']	
	));

    header("Location: /paymentmethods");
	exit;
});

//delete
$app->get('/paymentmethods/{id}/delete', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();


    $formaspagamento = $sql->select("delete  from payment_methods
    where id=:id", array(
      ":id"=>$args['id'] 
    ));
  
    header("Location: /paymentmethods");
	exit;
 
 });

 //----------------------- COSTS CENTER ------------------------
 //list
$app->get('/costscenter', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
 
    $costs_center = $sql->select("select * from costs_center");
 
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'costscenter.html', [
   
             "costs_center" => $costs_center,
			 "user_name"=> $user_name
 
     ]);
 });

 // mostra a tela para criar
$app->get('/costscenter/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


 
    $view = Twig::fromRequest($request);

    return $view->render($response, 'costscenter-create.html', [
        "user_name"=> $user_name
    ]);
});

// save create
$app->post('/costscenter/create', function ($request, $response, $args) {


	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();

	$inserir_usuario = $sql->select("insert into
	 costs_center(name,type) values(:name,:type)", array(
		":name"=>$_POST['name'],
		":type"=>$_POST['cost_type']

	));

    
    header("Location: /costscenter");
	exit;

});

// update
$app->get('/costscenter/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();

    $cost_center = $sql->select("select * from costs_center
	  where id=:id", array(
		":id"=>$args['id']	
	));
 
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'costscenter-update.html', [
    
             "cost_center" => $cost_center[0],
			 "user_name"=> $user_name
 
     ]);
 });
//save update
$app->post('/costscenter/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();

    $sql->select("update costs_center
     set name=:name, type=:type
	  where id=:id", array(
        ":name"=>$_POST['name'],
        ":type"=>$_POST['cost_type'],
		":id"=>$args['id']	
	));

    
    header("Location: /costscenter");
	exit;
});

$app->get('/costscenter/{id}/delete', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();


    $formaspagamento = $sql->select("delete  from costs_center
    where id=:id", array(
      ":id"=>$args['id'] 
    ));
  
    header("Location: /costscenter");
	exit;
 
 });
//----------------------- SALES ------------------------

//list
$app->get('/sales', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
 
    $sales = $sql->select("select v.id as sale_id,
			DATE_FORMAT(v.date_sale,'%d/%m/%Y') as date_sale,
			v.time_sale as time_sale,
			v.value_sale as value_sale,
			v.percentage_discount as percentage_discount,
			v.final_value_after_discount as final_value_after_discount,
			c.name as client_name
			from sales v, clients c 
			where(v.id_client = c.id) order by v.date_sale desc");
 
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'sales.html', [
    
             "sales" => $sales,
			 "user_name"=> $user_name
 
     ]);
 });




// create
$app->get('/sales/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
 
    $clients = $sql->select("select * from clients");

    $sql2 = new Sql();
 
    $products = $sql2->select("select * from products");


    $sql3 = new Sql();
 
    $payment_methods = $sql3->select("select * from payment_methods");
 

    $sql4 = new Sql();
 
    $costs_center = $sql4->select("select * from costs_center where ((type='INCOMING') OR (type='INCOMING/OUTGOING')) "); 




    $view = Twig::fromRequest($request);

    return $view->render($response, 'sales-create.html', [

        "clients" => $clients,
        "products" => $products,
        "payment_methods" => $payment_methods,
        "costs_center" => $costs_center,
		"user_name"=> $user_name

   
    ]);
});

$app->post('/sales/create', function() {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];

	
	
   if( isset($_POST["check_in_cash"])){
	   // sale in cash
	   $json_products_string = $_POST["memo_products"];

	   $array_products = json_decode($json_products_string);

	   $sale_final_value = 0.0;
	   $quantity_products_sale = 0;
	   foreach ($array_products as $value)
	   {
   
	   
	   $quantity_products_sale = $quantity_products_sale + $value->QUANTITY;
   
	   $sale_final_value = $sale_final_value + ($value->QUANTITY * $value->UNITARYVALUE);
   
   
	   }

     	 $sql = new Sql();
		 $sql2 = new Sql();
		 $sql3 = new Sql();
		 $sql4 = new Sql();
		 $sql5 = new Sql();

		 $note_value = ' ';

		 $sale_time = date('Y-m-d H:i:s');

		 //$sale_type = "À Vista";
		 $sale_type = "Cash";

		

		 if   (!(isset($_POST["v_value_disc_perc_cash"]))   
		  or ((int)$_POST["v_value_disc_perc_cash"] == 0))   {

			$_POST["v_sale_value_after_desc"] = $sale_final_value;
		}
	
		$results = $sql->select("insert into sales(id_client,id_cost_center,id_payment_method,
		value_sale,date_sale,tax_invoice,note,quantity_items,time_sale,percentage_discount,final_value_after_discount,sale_type)
		values (:id_client,:id_cost_center,:id_payment_method,
		:value_sale,:date_sale,:tax_invoice,:note,:quantity_items,:time_sale,:percentage_discount,:final_value_after_discount,:sale_type) ",
		  array(

			":id_client"=> $_POST["id_client"],
            ":id_cost_center"=> $_POST["id_cost_center"],
            ":id_payment_method"=>$_POST["id_payment_method"],
            ":value_sale"=> $sale_final_value,
            ":date_sale"=> $_POST["date_sale"],
            ":tax_invoice"=> $_POST["tax_invoice"],
            ":note"=> $note_value,
			":quantity_items"=> $quantity_products_sale,
			":time_sale"=> $sale_time,
			":percentage_discount"=> $_POST["v_value_disc_perc_cash"],
			":final_value_after_discount"=> $_POST["v_sale_value_after_desc"],
			":sale_type"=>$sale_type
			 
		 ));

	
		 
		 $id_new_sale = $sql2->select("select id from sales where
		 (id_client=:id_client) and (id_cost_center=:id_cost_center)
		 and (id_payment_method=:id_payment_method) and
		(value_sale=:value_sale) and (date_sale=:date_sale) and (tax_invoice=:tax_invoice) and
		(note=:note) and (quantity_items=:quantity_items) and (time_sale=:time_sale)",  array(
		 
			":id_client"=> $_POST["id_client"],
            ":id_cost_center"=> $_POST["id_cost_center"],
            ":id_payment_method"=>$_POST["id_payment_method"],
            ":value_sale"=> $sale_final_value,
            ":date_sale"=> $_POST["date_sale"],
            ":tax_invoice"=> $_POST["tax_invoice"],
            ":note"=> $note_value,
			":quantity_items"=> $quantity_products_sale,
			":time_sale"=> $sale_time
		   
	   ));

	   
	   
			// decreases the stock of products and adds to the product sold
			foreach ($array_products as $value)
			{
			
			
			$insert_product_sale = $sql3->select("insert into saleproduct (id_product,id_sale,quantity,unit_value)
			values (:id_product,:id_sale,:quantity,:unit_value) ",
				array(

					":id_product"=>$value->IDPRODUCT,
					":id_sale"=> $id_new_sale[0]['id'],
					":quantity"=>$value->QUANTITY,
					":unit_value"=> $value->UNITARYVALUE
					
				));
           
			
		    		
       
				$update_product_stock = $sql4->select("update products p 
				set p.stock = p.stock -:quantity where p.id=:id ",
					array(
			
						":id"=>$value->IDPRODUCT,
						":quantity"=>$value->QUANTITY
						
						
					));	 
           
                 
			}


			   /*  original values
					$_status = "PAGA";

				$_description = "Pagamento da Venda de Cód: " . $id_new_sale[0]['codigo'];
				$payment_type = "Venda à Vista";
				$my_type ="ENTRADA";
				$_num_doc = " ";
                
				*/

				$_status = "PAID";

				$_description = "Payment of the sale id: " . $id_new_sale[0]['id'];
				$payment_type = "Cash Sale";
				$my_type ="INCOMING";
				$_num_doc = " ";

				$new_account = $sql3->select("insert into accounts (id_client,
				id_cost_center,id_sale,id_payment_method,value,total_value,
				issue_date,expiration_date,payment_date,status,document_number,
				description,payment_type,account_type)
				values (:id_client,:id_cost_center,:id_sale,
				:id_payment_method,:value,:total_value,:issue_date,
				:expiration_date,:payment_date,:status,:document_number,
				:description,:payment_type,:account_type) ",array(
				
					":id_client"=>$_POST["id_client"],
					":id_cost_center"=>$_POST["id_cost_center"],
					":id_sale"=>$id_new_sale[0]['id'],
					":id_payment_method"=>$_POST["id_payment_method"],
					":value"=>$_POST["v_sale_value_after_desc"],
					":total_value"=>$_POST["v_sale_value_after_desc"],
					":issue_date"=>$_POST["date_sale"],
					":expiration_date"=>$_POST["date_sale"],
                    ":payment_date"=> $sale_time,
					":status"=>$_status,
					":document_number"=>$_num_doc,
					":description"=>$_description,
					":payment_type"=>$payment_type,
					":account_type"=>$my_type
					
				));

     

		 header("Location: /sales");
		 exit;

               


   }else{ // installment sale

	
	$json_products_string = $_POST["memo_products"];

	$array_products = json_decode($json_products_string);

	$json_installments_string = $_POST["memo_installments"];
	
	$array_installments = json_decode($json_installments_string);


	
	$sale_final_value = 0.0;
	$quantity_products_sale = 0;
	foreach ($array_products as $value)
	{

	$quantity_products_sale = $quantity_products_sale + $value->QUANTITY;

	$sale_final_value = $sale_final_value + ($value->QUANTITY * $value->UNITARYVALUE);


	}


		 $sql = new Sql();
		 $sql2 = new Sql();
		 $sql3 = new Sql();
		 $sql4 = new Sql();
		 $sql5 = new Sql();

		 $note_value = ' ';

		 $sale_time = date('Y-m-d H:i:s');
	
		 //$sale_type = "Parcelada";
		 $sale_type = "Installment";

		$results = $sql->select("insert into sales(id_client,id_cost_center,id_payment_method,
		value_sale,final_value_after_discount,date_sale,tax_invoice,note,quantity_items,time_sale,sale_type)
		values (:id_client,:id_cost_center,:id_payment_method,
		:value_sale,:final_value_after_discount,:date_sale,:tax_invoice,:note,:quantity_items,:time_sale,:sale_type) ",
		  array(

			":id_client"=> $_POST["id_client"],
            ":id_cost_center"=> $_POST["id_cost_center"],
            ":id_payment_method"=>$_POST["id_payment_method"],
			":value_sale"=> $sale_final_value,
			":final_value_after_discount"=> $sale_final_value,
            ":date_sale"=> $_POST["date_sale"],
            ":tax_invoice"=> $_POST["tax_invoice"],
            ":note"=> $note_value,
			":quantity_items"=> $quantity_products_sale,
			":time_sale"=> $sale_time,
			":sale_type"=>$sale_type
			 
		 ));


		 $id_new_sale = $sql2->select("select id from sales where
		 (id_client=:id_client) and (id_cost_center=:id_cost_center)
		 and (id_payment_method=:id_payment_method) and
		(value_sale=:value_sale) and (date_sale=:date_sale) and (tax_invoice=:tax_invoice) and
		(note=:note) and (quantity_items=:quantity_items) and (time_sale=:time_sale)",  array(
		 
			":id_client"=> $_POST["id_client"],
            ":id_cost_center"=> $_POST["id_cost_center"],
            ":id_payment_method"=>$_POST["id_payment_method"],
            ":value_sale"=> $sale_final_value,
            ":date_sale"=> $_POST["date_sale"],
            ":tax_invoice"=> $_POST["tax_invoice"],
            ":note"=> $note_value,
			":quantity_items"=> $quantity_products_sale,
			":time_sale"=> $sale_time
		   
	   ));
	

	
	// decreases the stock of products and adds to the product sold
	 foreach ($array_products as $value)
	 {
	

	 $insert_product_sale = $sql3->select("insert into saleproduct (id_product,id_sale,quantity,unit_value)
	 values (:id_product,:id_sale,:quantity,:unit_value) ",
		  array(

			":id_product"=>$value->IDPRODUCT,
			":id_sale"=> $id_new_sale[0]['id'],
			":quantity"=>$value->QUANTITY,
			":unit_value"=> $value->UNITARYVALUE
			 
		 ));


		 $update_product_stock = $sql4->select("update products p 
		 set p.stock = p.stock -:quantity where p.id=:id ",
			  array(
	
				":id"=>$value->IDPRODUCT,
				":quantity"=>$value->QUANTITY
				
				 
			 ));	 


	 }


	 // for accounts
	 foreach ($array_installments as $value)
	 {

		// $_status = "EM ABERTO";

		// $_description = "Parcela da Venda de Cód: " . $id_new_sale[0]['id'];
		// $payment_type = "OUTRO";
		// $my_type ="ENTRADA";

	
		$_status = "UNPAID";

		$_description = "Payment of the sale id: " . $id_new_sale[0]['id'];
		$payment_type = "OTHER";
		$my_type ="INCOMING";

		$new_account = $sql3->select("insert into accounts (id_client,
		id_cost_center,id_sale,id_payment_method,value,
		issue_date,expiration_date,status,document_number,
		description,payment_type,account_type)
		values (:id_client,:id_cost_center,:id_sale,
		:id_payment_method,:value,:issue_date,
		:expiration_date,:status,:document_number,
		:description,:payment_type,:account_type) ",array(
		   
			":id_client"=>$_POST["id_client"],
			":id_cost_center"=>$_POST["id_cost_center"],
			":id_sale"=>$id_new_sale[0]['id'],
			":id_payment_method"=>$_POST["id_payment_method"],
			":value"=>$value->INSTALLMENTVALUE,
			":issue_date"=>$_POST["date_sale"],
			":expiration_date"=>convert_date_to_db_type($value->EXPIRATION),
			":status"=>$_status,
			":document_number"=>$value->NUMDOC,
			":description"=>$_description,
			":payment_type"=>$payment_type,
			":account_type"=>$my_type
			 
		  ));


	 }
	 	
		header("Location: /sales");
		exit;
	
	}// installment sale
		
	});
 //---------------------------------------
// show sale
$app->get('/sales/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


	//User::verifyLogin();
	
	$sql = new Sql();
	$sql2 = new Sql();
	$sql3 = new Sql();

	
	$sale = $sql->select("select v.id as id_sale,
    v.value_sale as value_sale,
    v.percentage_discount as percentage_discount,
	FORMAT(((v.value_sale * v.percentage_discount)/100),2) as value_discount_real,
	v.final_value_after_discount
	as final_value_after_discount,
    v.sale_type as sale_type,
	DATE_FORMAT(v.date_sale,'%d/%m/%Y') as date_sale,
   v.time_sale as time_sale,
   v.quantity_items as quantity_items,
   c.name as client_name,
   fp.name as payment_method_name,
   cc.name as cost_center_name
   from
   sales v, clients c, costs_center cc,
	payment_methods fp
   where
   (v.id_client = c.id) and 
   (v.id_cost_center = cc.id) and
   (v.id_payment_method =fp.id) and
   (v.id=:id)", array(
		":id"=>$args['id']  
	));

	$saleproduct = $sql2->select("select distinct
    p.id as id_product,
    p.name as name_product,
    pv.quantity as quantity,
    pv.unit_value as unit_value,
    FORMAT((pv.quantity * pv.unit_value),2) as subtotal
    
    from  sales v, saleproduct pv, products p
    where (pv.id_sale = v.id) and
    (pv.id_product = p.id) and
    (v.id=:id)", array(
        ":id"=>$args['id'] 
    
    ));


	$saleaccounts = $sql3->select("select distinct
    c.id as id_account,
    c.value as account_value,
    c.total_value as amount_paid,
    DATE_FORMAT(c.expiration_date,'%d/%m/%Y') as expiration_date,
    DATE_FORMAT(c.payment_date,'%d/%m/%Y') as payment_date,
    c.status as status
    
    from sales v, accounts c
    where 
    (v.id = c.id_sale) and 
    (v.id=:id)", array(
        ":id"=>$args['id']
    
    ));



     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'sales-show.html', [
    
			 "sale"=>$sale,
	        "saleproduct"=>$saleproduct,
		    "saleaccounts"=>$saleaccounts,
			"user_name"=> $user_name
	 
 
     ]);
 });
 //----------------------------------------------------

//delete sale 
$app->get('/sales/{id}/delete', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


//	User::verifyLogin();

	  $sql = new Sql();
	  $sql2 = new Sql();
	  $sql3 = new Sql();
	  $sql4 = new Sql();
	  $sql5 = new Sql();

	 // select products of the sale

	 $select_productsold = $sql->select("select distinct p.id as id_product,
	 pv.id as id_saleproduct,
	 p.name as name_product, pv.quantity as quantity,
	 v.id as id_sale

	   from saleproduct pv, products p, sales v
	 where (pv.id_sale = v.id) and 
	 (pv.id_product = p.id) and 
	 (v.id = :id) ",
			array(

				
				":id"=>$args['id']
				
			));
	

	

	foreach ($select_productsold as $value)
	{
	// in each product sold replenishes the stock of the product

	 $sql2->select("update products p 
			set p.stock = p.stock +:quantity where p.id=:id ",
				array(
		
					":id"=>$value["id_product"],
					":quantity"=>$value["quantity"]
					
					
				));
	

	}

	

	// remove sold products from sale
	
	
	 $sql3->query("delete from saleproduct where id_sale=:id", array(

		
		":id"=>$args['id']

	));


	// remove accounts from sale


	 $sql4->query("delete from accounts where id_sale=:id", array(

		
		":id"=>$args['id']

	));

	// delete sale


	$sql5->query("delete from sales where id=:id", array(

		
		":id"=>$args['id']

	));


	header("Location: /sales");
	exit;
	
});
//-----------------------PURCHASES ------------------------

//list
$app->get('/purchases', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
 
    $purchases = $sql->select("select v.id as purchase_id,
			DATE_FORMAT(v.date_purchase,'%d/%m/%Y') as date_purchase,
			v.time_purchase as time_purchase,
			v.value_purchase as value_purchase,
			v.percentage_discount as percentage_discount,
			v.final_value_after_discount as final_value_after_discount,
			c.name as supplier_name
			from purchases v, suppliers c 
			where(v.id_supplier = c.id) order by v.date_purchase desc");
 
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'purchases.html', [
    
             "purchases" => $purchases,
			 "user_name"=> $user_name
 
     ]);
 });
// create
$app->get('/purchases/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();
 
    $suppliers = $sql->select("select * from suppliers");

    $sql2 = new Sql();
 
    $products = $sql2->select("select * from products");


    $sql3 = new Sql();
 
    $payment_methods = $sql3->select("select * from payment_methods");
 

    $sql4 = new Sql();
 
    $costs_center = $sql4->select("select * from costs_center where ((type='OUTGOING') OR (type='INCOMING/OUTGOING')) "); 


    $view = Twig::fromRequest($request);

    return $view->render($response, 'purchases-create.html', [

        "suppliers" => $suppliers,
        "products" => $products,
        "payment_methods" => $payment_methods,
        "costs_center" => $costs_center,
		"user_name"=> $user_name

   
    ]);
});
$app->post('/purchases/create', function() {

// 	as the functionality of the purchase is 
// practically the same as that of the sale,
// all the code was reused. Changes were made
// where necessary which is on the part of the 
// supplier, purchase price, increase in stock, etc.

if (!isset($_SESSION['User'])){
	//user not logged in

	header("Location: /login");
	exit;
}

$user_name = $_SESSION['User'];

		
		
	   if( isset($_POST["check_in_cash"])){
		   // sale in cash
		   $json_products_string = $_POST["memo_products"];
	
		   $array_products = json_decode($json_products_string);
	
		   $sale_final_value = 0.0;
		   $quantity_products_sale = 0;
		   foreach ($array_products as $value)
		   {
	   
		   
		   $quantity_products_sale = $quantity_products_sale + $value->QUANTITY;
	   
		   $sale_final_value = $sale_final_value + ($value->QUANTITY * $value->UNITARYVALUE);
	   
	   
		   }
	
			  $sql = new Sql();
			 $sql2 = new Sql();
			 $sql3 = new Sql();
			 $sql4 = new Sql();
			 $sql5 = new Sql();
	
			 $note_value = ' ';
	
			 $sale_time = date('Y-m-d H:i:s');
	
			 //$sale_type = "À Vista";
			 $sale_type = "Cash";
	
			
	
			 if   (!(isset($_POST["v_value_disc_perc_cash"]))   
			  or ((int)$_POST["v_value_disc_perc_cash"] == 0))   {
	
				$_POST["v_sale_value_after_desc"] = $sale_final_value;
			}
		
			$results = $sql->select("insert into purchases(id_supplier,id_cost_center,id_payment_method,
			value_purchase,date_purchase,tax_invoice,note,quantity_items,time_purchase,percentage_discount,final_value_after_discount,purchase_type)
			values (:id_supplier,:id_cost_center,:id_payment_method,
			:value_purchase,:date_purchase,:tax_invoice,:note,:quantity_items,:time_purchase,:percentage_discount,:final_value_after_discount,:purchase_type) ",
			  array(
	
				":id_supplier"=> $_POST["id_client"],
				":id_cost_center"=> $_POST["id_cost_center"],
				":id_payment_method"=>$_POST["id_payment_method"],
				":value_purchase"=> $sale_final_value,
				":date_purchase"=> $_POST["date_sale"],
				":tax_invoice"=> $_POST["tax_invoice"],
				":note"=> $note_value,
				":quantity_items"=> $quantity_products_sale,
				":time_purchase"=> $sale_time,
				":percentage_discount"=> $_POST["v_value_disc_perc_cash"],
				":final_value_after_discount"=> $_POST["v_sale_value_after_desc"],
				":purchase_type"=>$sale_type
				 
			 ));
	
		     
			 
			 $id_new_sale = $sql2->select("select id from purchases where
			 (id_supplier=:id_supplier) and (id_cost_center=:id_cost_center)
			 and (id_payment_method=:id_payment_method) and
			(value_purchase=:value_purchase) and (date_purchase=:date_purchase) and (tax_invoice=:tax_invoice) and
			(note=:note) and (quantity_items=:quantity_items) and (time_purchase=:time_purchase)",  array(
			 
				":id_supplier"=> $_POST["id_client"],
				":id_cost_center"=> $_POST["id_cost_center"],
				":id_payment_method"=>$_POST["id_payment_method"],
				":value_purchase"=> $sale_final_value,
				":date_purchase"=> $_POST["date_sale"],
				":tax_invoice"=> $_POST["tax_invoice"],
				":note"=> $note_value,
				":quantity_items"=> $quantity_products_sale,
				":time_purchase"=> $sale_time
			   
		   ));
	
		   
		   
				// decreases the stock of products and adds to the product sold
				foreach ($array_products as $value)
				{
				
				
				$insert_product_sale = $sql3->select("insert into purchaseproduct (id_product,id_purchase,quantity,unit_value)
				values (:id_product,:id_purchase,:quantity,:unit_value) ",
					array(
	
						":id_product"=>$value->IDPRODUCT,
						":id_purchase"=> $id_new_sale[0]['id'],
						":quantity"=>$value->QUANTITY,
						":unit_value"=> $value->UNITARYVALUE
						
					));
			   
				
						//add the number of products
					$update_product_stock = $sql4->select("update products p 
					set p.stock = p.stock +:quantity where p.id=:id ",
						array(
				
							":id"=>$value->IDPRODUCT,
							":quantity"=>$value->QUANTITY
							
							
						));	 
			   
					 
				}
	
				
	
				   /*  original values
						$_status = "PAGA";
	
					$_description = "Pagamento da Venda de Cód: " . $id_new_sale[0]['codigo'];
					$payment_type = "Venda à Vista";
					$my_type ="ENTRADA";
					$_num_doc = " ";
					
					*/
	
					$_status = "PAID";
	
					$_description = "Payment of the purchase id: " . $id_new_sale[0]['id'];
					$payment_type = "Cash Purchase";
					$my_type ="OUTGOING";
					$_num_doc = " ";
	
					$new_account = $sql3->select("insert into accounts (id_supplier,
					id_cost_center,id_purchase,id_payment_method,value,total_value,
					issue_date,expiration_date,payment_date,status,document_number,
					description,payment_type,account_type)
					values (:id_supplier,:id_cost_center,:id_purchase,
					:id_payment_method,:value,:total_value,:issue_date,
					:expiration_date,:payment_date,:status,:document_number,
					:description,:payment_type,:account_type) ",array(
					
						":id_supplier"=>$_POST["id_client"],
						":id_cost_center"=>$_POST["id_cost_center"],
						":id_purchase"=>$id_new_sale[0]['id'],
						":id_payment_method"=>$_POST["id_payment_method"],
						":value"=>$_POST["v_sale_value_after_desc"],
						":total_value"=>$_POST["v_sale_value_after_desc"],
						":issue_date"=>$_POST["date_sale"],
						":expiration_date"=>$_POST["date_sale"],
						":payment_date"=> $sale_time,
						":status"=>$_status,
						":document_number"=>$_num_doc,
						":description"=>$_description,
						":payment_type"=>$payment_type,
						":account_type"=>$my_type
						
					));
	              
					
		 
	
			 header("Location: /purchases");
			 exit;
	
				   
	
	
	   }else{ // installment purchase
	
		
		$json_products_string = $_POST["memo_products"];
	
		$array_products = json_decode($json_products_string);
	
		$json_installments_string = $_POST["memo_installments"];
		
		$array_installments = json_decode($json_installments_string);
	
	
		
		$sale_final_value = 0.0;
		$quantity_products_sale = 0;
		foreach ($array_products as $value)
		{
	
		$quantity_products_sale = $quantity_products_sale + $value->QUANTITY;
	
		$sale_final_value = $sale_final_value + ($value->QUANTITY * $value->UNITARYVALUE);
	
	
		}
	
	
			 $sql = new Sql();
			 $sql2 = new Sql();
			 $sql3 = new Sql();
			 $sql4 = new Sql();
			 $sql5 = new Sql();
	
			 $note_value = ' ';
	
			 $sale_time = date('Y-m-d H:i:s');
		
			 //$sale_type = "Parcelada";
			 $sale_type = "Installment";
	
			$results = $sql->select("insert into purchases(id_supplier,id_cost_center,id_payment_method,
			value_purchase,final_value_after_discount,date_purchase,tax_invoice,note,quantity_items,time_purchase,purchase_type)
			values (:id_supplier,:id_cost_center,:id_payment_method,
			:value_purchase,:final_value_after_discount,:date_purchase,:tax_invoice,:note,:quantity_items,:time_purchase,:purchase_type) ",
			  array(
	
				":id_supplier"=> $_POST["id_client"],
				":id_cost_center"=> $_POST["id_cost_center"],
				":id_payment_method"=>$_POST["id_payment_method"],
				":value_purchase"=> $sale_final_value,
				":final_value_after_discount"=> $sale_final_value,
				":date_purchase"=> $_POST["date_sale"],
				":tax_invoice"=> $_POST["tax_invoice"],
				":note"=> $note_value,
				":quantity_items"=> $quantity_products_sale,
				":time_purchase"=> $sale_time,
				":purchase_type"=>$sale_type
				 
			 ));

			 
	
	
			 $id_new_sale = $sql2->select("select id from purchases where
			 (id_supplier=:id_supplier) and (id_cost_center=:id_cost_center)
			 and (id_payment_method=:id_payment_method) and
			(value_purchase=:value_purchase) and (date_purchase=:date_purchase) and (tax_invoice=:tax_invoice) and
			(note=:note) and (quantity_items=:quantity_items) and (time_purchase=:time_purchase)",  array(
			 
				":id_supplier"=> $_POST["id_client"],
				":id_cost_center"=> $_POST["id_cost_center"],
				":id_payment_method"=>$_POST["id_payment_method"],
				":value_purchase"=> $sale_final_value,
				":date_purchase"=> $_POST["date_sale"],
				":tax_invoice"=> $_POST["tax_invoice"],
				":note"=> $note_value,
				":quantity_items"=> $quantity_products_sale,
				":time_purchase"=> $sale_time
			   
		   ));
		
	
		
		// decreases the stock of products and adds to the product sold
		 foreach ($array_products as $value)
		 {
		
	
		 $insert_product_sale = $sql3->select("insert into purchaseproduct (id_product,id_purchase,quantity,unit_value)
		 values (:id_product,:id_purchase,:quantity,:unit_value) ",
			  array(
	
				":id_product"=>$value->IDPRODUCT,
				":id_purchase"=> $id_new_sale[0]['id'],
				":quantity"=>$value->QUANTITY,
				":unit_value"=> $value->UNITARYVALUE
				 
			 ));
	
	
			 $update_product_stock = $sql4->select("update products p 
			 set p.stock = p.stock +:quantity where p.id=:id ",
				  array(
		
					":id"=>$value->IDPRODUCT,
					":quantity"=>$value->QUANTITY
					
					 
				 ));	 
	
	
		 }



	
	
		 // for accounts
		 foreach ($array_installments as $value)
		 {
	
			// $_status = "EM ABERTO";
	
			// $_description = "Parcela da Venda de Cód: " . $id_new_sale[0]['id'];
			// $payment_type = "OUTRO";
			// $my_type ="ENTRADA";
	
		
			$_status = "UNPAID";
	
			$_description = "Payment of the purchase id: " . $id_new_sale[0]['id'];
			$payment_type = "OTHER";
			$my_type ="OUTGOING";
	
			$new_account = $sql3->select("insert into accounts (id_supplier,
			id_cost_center,id_purchase,id_payment_method,value,
			issue_date,expiration_date,status,document_number,
			description,payment_type,account_type)
			values (:id_supplier,:id_cost_center,:id_purchase,
			:id_payment_method,:value,:issue_date,
			:expiration_date,:status,:document_number,
			:description,:payment_type,:account_type) ",array(
			   
				":id_supplier"=>$_POST["id_client"],
				":id_cost_center"=>$_POST["id_cost_center"],
				":id_purchase"=>$id_new_sale[0]['id'],
				":id_payment_method"=>$_POST["id_payment_method"],
				":value"=>$value->INSTALLMENTVALUE,
				":issue_date"=>$_POST["date_sale"],
				":expiration_date"=>convert_date_to_db_type($value->EXPIRATION),
				":status"=>$_status,
				":document_number"=>$value->NUMDOC,
				":description"=>$_description,
				":payment_type"=>$payment_type,
				":account_type"=>$my_type
				 
			  ));
	
	
		 }
			 
			header("Location: /purchases");
			exit;
		
		}// installment sale
			
		});

// show purchase
$app->get('/purchases/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];

	
	$sql = new Sql();
	$sql2 = new Sql();
	$sql3 = new Sql();

	
	$purchase = $sql->select("select v.id as id_purchase,
    v.value_purchase as value_purchase,
    v.percentage_discount as percentage_discount,
	FORMAT(((v.value_purchase * v.percentage_discount)/100),2) as value_discount_real,
	v.final_value_after_discount
	as final_value_after_discount,
    v.purchase_type as purchase_type,
	DATE_FORMAT(v.date_purchase,'%d/%m/%Y') as date_purchase,
   v.time_purchase as time_purchase,
   v.quantity_items as quantity_items,
   c.name as supplier_name,
   fp.name as payment_method_name,
   cc.name as cost_center_name
   from
   purchases v, suppliers c, costs_center cc,
	payment_methods fp
   where
   (v.id_supplier = c.id) and 
   (v.id_cost_center = cc.id) and
   (v.id_payment_method =fp.id) and
   (v.id=:id)", array(
		":id"=>$args['id']  
	));

	$purchaseproduct = $sql2->select("select distinct
    p.id as id_product,
    p.name as name_product,
    pv.quantity as quantity,
    pv.unit_value as unit_value,
    FORMAT((pv.quantity * pv.unit_value),2) as subtotal
    
    from  purchases v, purchaseproduct pv, products p
    where (pv.id_purchase = v.id) and
    (pv.id_product = p.id) and
    (v.id=:id)", array(
        ":id"=>$args['id'] 
    
    ));


	$purchasesaccounts = $sql3->select("select distinct
    c.id as id_account,
    c.value as account_value,
    c.total_value as amount_paid,
    DATE_FORMAT(c.expiration_date,'%d/%m/%Y') as expiration_date,
    DATE_FORMAT(c.payment_date,'%d/%m/%Y') as payment_date,
    c.status as status
    
    from purchases v, accounts c
    where 
    (v.id = c.id_purchase) and 
    (v.id=:id)", array(
        ":id"=>$args['id']
    
    ));


     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'purchases-show.html', [
    
			 "purchase"=>$purchase,
	         "purchaseproduct"=>$purchaseproduct,
		    "purchasesaccounts"=>$purchasesaccounts,
			"user_name"=> $user_name
	 
 
     ]);
 });

 //delete purchase 
$app->get('/purchases/{id}/delete', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];

	
		  $sql = new Sql();
		  $sql2 = new Sql();
		  $sql3 = new Sql();
		  $sql4 = new Sql();
		  $sql5 = new Sql();
	
		 // select products of the purchase
	
		 $select_productpurchase = $sql->select("select distinct p.id as id_product,
		 pv.id as id_purchaseproduct,
		 p.name as name_product, pv.quantity as quantity,
		 v.id as id_purchase
	
		   from purchaseproduct pv, products p, purchases v
		 where (pv.id_purchase = v.id) and 
		 (pv.id_product = p.id) and 
		 (v.id = :id) ",
				array(
	
					
					":id"=>$args['id']
					
				));
		
	
		
	
		foreach ($select_productpurchase as $value)
		{
		// in each product purchased replenishes the stock of the product
	
		 $sql2->select("update products p 
				set p.stock = p.stock -:quantity where p.id=:id ",
					array(
			
						":id"=>$value["id_product"],
						":quantity"=>$value["quantity"]
						
						
					));
		
	
		}
	
		
	
		// remove sold products from purchase
		
		
		 $sql3->query("delete from purchaseproduct where id_purchase=:id", array(
	
			
			":id"=>$args['id']
	
		));
	
	
		// remove accounts from purchase
	
	
		 $sql4->query("delete from accounts where id_purchase=:id", array(
	
			
			":id"=>$args['id']
	
		));
	
		// delete purchase
	
	
		$sql5->query("delete from purchases where id=:id", array(
	
			
			":id"=>$args['id']
	
		));
	
	
		header("Location: /purchases");
		exit;
		
	});
//----------------- account payable -------------------

// list

$app->get('/accountpayable', function($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];



	$sql = new Sql();
	$sql1 = new Sql();
	$sql2 = new Sql();
        
	//$contasapagar
	$accountpayable = $sql->select("select distinct 
	c.id as id_account,
	c.description as description,
	f.name as name_supplier,
	c.document_number as document_number,
	DATE_FORMAT(c.expiration_date,'%d/%m/%Y') as expiration_date,
	c.value as value,
	c.total_value as amount_paid,
	DATE_FORMAT(c.payment_date,'%d/%m/%Y') as payment_date,
	c.status as status


	from accounts c, suppliers f 
	where((c.id_supplier = f.id) 
	 and (c.account_type = 'OUTGOING'))
	order by c.id asc");


   //$soma_contas_pagas
   $sum_paid_account = $sql1->select("select distinct 
   sum(accounts.total_value) as total_value
   from accounts
   where((accounts.account_type ='OUTGOING') and (accounts.status='PAID') )");


   // $soma_contas_em_aberto
   $sum_unpaid_account = $sql2->select("select distinct 
   sum(accounts.value) as total_value
   from accounts
   where((accounts.account_type ='OUTGOING') and (accounts.status='UNPAID') )");



   $view = Twig::fromRequest($request);

    return $view->render($response, 'accountpayable.html', [

        "accountpayable"=>$accountpayable,
		"sum_paid_account"=> $sum_paid_account,
		"sum_unpaid_account"=> $sum_unpaid_account,
		"user_name"=> $user_name

   
    ]);	
});

// create
$app->get('/accountpayable/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


	$sql = new Sql();
	$sql1 = new Sql();

	$suppliers = $sql->select("select * from suppliers");

    $costs_center = $sql1->select("select * from costs_center where ((type='OUTGOING') OR (type='INCOMING/OUTGOING')) "); 

 
	$view = Twig::fromRequest($request);

	return $view->render($response, 'accountpayable-create.html', [

		"suppliers"=>$suppliers,
		"costs_center"=> $costs_center,
		"user_name"=> $user_name
		
	]);
});
// save create
$app->post('/accountpayable/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


	$_POST["value"] =  str_replace(",",".", $_POST["value"] );

	

	 $payment_type = "OTHER";// "OUTRO"
	 $status = "UNPAID"; //"EM ABERTO"
	 $account_type = "OUTGOING"; //"SAIDA"

	$sql2 = new Sql();
	$incluir_conta = $sql2->select(" 	
	insert into accounts(id_supplier,id_cost_center,value,
	issue_date,expiration_date,document_number,description,
	payment_type,status,account_type) values(:id_supplier,
	:id_cost_center,:value,
	:issue_date,:expiration_date,
	:document_number,
	:description,
	:payment_type,:status,:account_type)",  array(
	  
		":id_supplier"=> $_POST['id_supplier'],
		":id_cost_center"=> $_POST['id_cost_center'],
		":value"=>$_POST['value'],
		":issue_date"=>$_POST['issue_date'],
		":expiration_date"=>$_POST['expiration_date'],
		":document_number"=>$_POST['document_number'],
		":description"=>$_POST['description'],
		":payment_type"=> $payment_type,
		":status"=> $status,
		":account_type"=> $account_type
	));

   
    
    header("Location: /accountpayable");
	exit;

});
// update

$app->get('/accountpayable/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];



	$sql = new Sql();
	$sql1 = new Sql();
	$sql2 = new Sql();

	$suppliers = $sql->select("select * from suppliers");

    $costs_center = $sql1->select("select * from costs_center where ((type='OUTGOING') OR (type='INCOMING/OUTGOING')) "); 

	$accountpayable = $sql2->select("select
	 c.id as id,
	c.id_supplier as id_supplier,
	f.name as name_supplier,
	c.id_cost_center as id_cost_center,
	cc.name as name_cost_center,
	c.value as value,
	c.issue_date as issue_date,
	c.expiration_date as expiration_date,
	c.document_number as document_number,
	c.description as description,
	c.payment_type as payment_type,
	c.status as status,
	c.account_type as account_type 
	from accounts c, suppliers f, costs_center cc
	where (c.id_supplier = f.id ) and (c.id_cost_center = cc.id) and
	(c.id=:id)",  array(
		"id"=>$args['id']
		 
	 ));

	
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'accountpayable-update.html', [
    
	    "suppliers"=>$suppliers,
		"costs_center"=> $costs_center,
        "accountpayable" => $accountpayable[0],
		"user_name"=> $user_name
 
     ]);
 });
//salve update
$app->post('/accountpayable/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];



    $_POST["value"] =  str_replace(",",".", $_POST["value"] );

	

	 $payment_type = "OTHER";// "OUTRO"
	 $status = "UNPAID"; //"EM ABERTO"
	 $account_type = "OUTGOING"; //"SAIDA"


$sql2 = new Sql();
$update_account = $sql2->select(" 	
update accounts set id_supplier=:id_supplier,
id_cost_center=:id_cost_center,
value=:value,
issue_date=:issue_date,
expiration_date=:expiration_date,
document_number=:document_number,
description=:description,
payment_type=:payment_type,
status=:status,
account_type=:account_type where id=:id",  array(
 
   ":id_supplier"=> $_POST['id_supplier'],
   ":id_cost_center"=> $_POST['id_cost_center'],
   ":value"=>$_POST['value'],
   ":issue_date"=>$_POST['issue_date'],
   ":expiration_date"=>$_POST['expiration_date'],
   ":document_number"=>$_POST['document_number'],
   ":description"=>$_POST['description'],
   ":payment_type"=> $payment_type,
   ":status"=> $status,
   ":account_type"=> $account_type,
   ":id"=>$args['id']
));


	header("Location: /accountpayable");
	exit;	

});

// pay the account

$app->get('/accountpayable-pay/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();


	$status_account = $sql->select("select
   c.status as status 
   from accounts c
   where c.id=:id",  array(
	":id"=>$args['id']	
		
	));

	if ($status_account[0]['status'] == "PAID"){
		
	 
		echo "<script> 
		  alert('Warning! This account has already been paid !');
		  window.location.href='/accountpayable';
		 </script>";
  
  
	}else{

		$sql2 = new Sql();

		$accountpayable = $sql2->select("select
		c.id as id,
	   c.id_supplier as id_supplier,
	   f.name as name_supplier,
	   c.id_cost_center as id_cost_center,
	   cc.name as name_cost_center,
	   c.value as value,
	   c.issue_date as issue_date,
	   c.expiration_date as expiration_date,
	   c.document_number as document_number,
	   c.description as description,
	   c.payment_type as payment_type,
	   c.status as status,
	   c.account_type as account_type 
	   from accounts c, suppliers f, costs_center cc
	   where (c.id_supplier = f.id ) and (c.id_cost_center = cc.id) and
	   (c.id=:id)",  array(
		   "id"=>$args['id']
			
		));
	   

	

	 $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'accountpayable-pay.html', [
   
	"accountpayable" => $accountpayable[0],
	"user_name"=> $user_name
 
     ]);
	

	}// else

 });

// save pay account

$app->post('/accountpayable-pay/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];




	$_POST["total_value"] =  str_replace(",",".", $_POST["total_value"] );
		
	$status = "PAID";


    $sql = new Sql();


	$pay_account = $sql->select(" 	
	update accounts set 
	total_value=:total_value,
	payment_date=:payment_date,
	status=:status where id=:id",  array(
	 
	   ":total_value"=>$_POST['total_value'],
	   ":payment_date"=>$_POST['payment_date'],
	   ":status"=> $status,
	   ":id"=>$args['id']	
	));

    
    header("Location: /accountpayable");
	exit;
});

// reverse payment

$app->get('/accountpayable-reverse/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


	$sql = new Sql();


	$status_account = $sql->select("select
   c.status as status 
   from accounts c
   where c.id=:id",  array(
	":id"=>$args['id']	
		
	));

	if ($status_account[0]['status'] == "UNPAID"){
		
	 
		echo "<script> 
		  alert('Warning! This account has not been paid and therefore your payment cannot be reversed !');
		  window.location.href='/accountpayable';
		 </script>";
  
  
	}else{

		$status = "UNPAID";

		$total_value = 0;
		
		
		$sql2 = new Sql();
		$reverse_account = $sql2->select(" 	
		update accounts set 
		total_value=:total_value,
		payment_date=:payment_date,
		status=:status where id=:id",  array(
		
		":total_value"=>$total_value,
		":payment_date"=>NULL,
		":status"=> $status,
		":id"=>$args['id']
		));

		header("Location: /accountpayable");
		exit;	


	}//else

	
 });
//delete
$app->get('/accountpayable/{id}/delete', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();


    $delete_account = $sql->select("delete  from accounts
    where id=:id", array(
      ":id"=>$args['id'] 
    ));
  
    header("Location: /accountpayable");
	exit;
 
 });
//----------------- account receivable -------------------
// list

$app->get('/accountreceivable', function($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];

	
		$sql = new Sql();
		$sql1 = new Sql();
		$sql2 = new Sql();
			
		//$contasareceber
		$accountreceivable = $sql->select("select distinct 
		c.id as id_account,
		c.description as description,
		f.name as name_client,
		c.document_number as document_number,
		DATE_FORMAT(c.expiration_date,'%d/%m/%Y') as expiration_date,
		c.value as value,
		c.total_value as amount_paid,
		DATE_FORMAT(c.payment_date,'%d/%m/%Y') as payment_date,
		c.status as status
	
	
		from accounts c, clients f 
		where((c.id_client = f.id) 
		 and (c.account_type = 'INCOMING'))
		order by c.id asc");
	
	
	   //$soma_contas_pagas
	   $sum_paid_account = $sql1->select("select distinct 
	   sum(accounts.total_value) as total_value
	   from accounts
	   where((accounts.account_type ='INCOMING') and (accounts.status='PAID') )");
	
	
	   // $soma_contas_em_aberto
	   $sum_unpaid_account = $sql2->select("select distinct 
	   sum(accounts.value) as total_value
	   from accounts
	   where((accounts.account_type ='INCOMING') and (accounts.status='UNPAID') )");
	
	
	
	   $view = Twig::fromRequest($request);
	
		return $view->render($response, 'accountreceivable.html', [
	
			"accountreceivable"=>$accountreceivable,
			"sum_paid_account"=> $sum_paid_account,
			"sum_unpaid_account"=> $sum_unpaid_account,
			"user_name"=> $user_name
	
	   
		]);	
	});
	
// create
$app->get('/accountreceivable/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


	$sql = new Sql();
	$sql1 = new Sql();

	$clients = $sql->select("select * from clients");

    $costs_center = $sql1->select("select * from costs_center where ((type='INCOMING') OR (type='INCOMING/OUTGOING')) "); 

 
	$view = Twig::fromRequest($request);

	return $view->render($response, 'accountreceivable-create.html', [

		"clients"=>$clients,
		"costs_center"=> $costs_center,
		"user_name"=> $user_name
		
	]);
});

// save create
$app->post('/accountreceivable/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


	$_POST["value"] =  str_replace(",",".", $_POST["value"] );

	

	 $payment_type = "OTHER";// "OUTRO"
	 $status = "UNPAID"; //"EM ABERTO"
	 $account_type = "INCOMING"; //"ENTRADA"

	$sql2 = new Sql();
	$incluir_conta = $sql2->select(" 	
	insert into accounts(id_client,id_cost_center,value,
	issue_date,expiration_date,document_number,description,
	payment_type,status,account_type) values(:id_client,
	:id_cost_center,:value,
	:issue_date,:expiration_date,
	:document_number,
	:description,
	:payment_type,:status,:account_type)",  array(
	  
		":id_client"=> $_POST['id_client'],
		":id_cost_center"=> $_POST['id_cost_center'],
		":value"=>$_POST['value'],
		":issue_date"=>$_POST['issue_date'],
		":expiration_date"=>$_POST['expiration_date'],
		":document_number"=>$_POST['document_number'],
		":description"=>$_POST['description'],
		":payment_type"=> $payment_type,
		":status"=> $status,
		":account_type"=> $account_type
	));

   
    
    header("Location: /accountreceivable");
	exit;

});

// update

$app->get('/accountreceivable/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];



	$sql = new Sql();
	$sql1 = new Sql();
	$sql2 = new Sql();

	$clients = $sql->select("select * from clients");

    $costs_center = $sql1->select("select * from costs_center where ((type='INCOMING') OR (type='INCOMING/OUTGOING')) "); 

	$accountreceivable = $sql2->select("select
	 c.id as id,
	c.id_client as id_client,
	f.name as name_client,
	c.id_cost_center as id_cost_center,
	cc.name as name_cost_center,
	c.value as value,
	c.issue_date as issue_date,
	c.expiration_date as expiration_date,
	c.document_number as document_number,
	c.description as description,
	c.payment_type as payment_type,
	c.status as status,
	c.account_type as account_type 
	from accounts c, clients f, costs_center cc
	where (c.id_client = f.id ) and (c.id_cost_center = cc.id) and
	(c.id=:id)",  array(
		"id"=>$args['id']
		 
	 ));

	
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'accountreceivable-update.html', [
    
	    "clients"=>$clients,
		"costs_center"=> $costs_center,
        "accountreceivable" => $accountreceivable[0],
		"user_name"=> $user_name
 
     ]);
 });

 //save update
$app->post('/accountreceivable/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];



    $_POST["value"] =  str_replace(",",".", $_POST["value"] );

	

	 $payment_type = "OTHER";// "OUTRO"
	 $status = "UNPAID"; //"EM ABERTO"
	 $account_type = "INCOMING"; //"SAIDA"


$sql2 = new Sql();
$update_account = $sql2->select(" 	
update accounts set id_client=:id_client,
id_cost_center=:id_cost_center,
value=:value,
issue_date=:issue_date,
expiration_date=:expiration_date,
document_number=:document_number,
description=:description,
payment_type=:payment_type,
status=:status,
account_type=:account_type where id=:id",  array(
 
   ":id_client"=> $_POST['id_client'],
   ":id_cost_center"=> $_POST['id_cost_center'],
   ":value"=>$_POST['value'],
   ":issue_date"=>$_POST['issue_date'],
   ":expiration_date"=>$_POST['expiration_date'],
   ":document_number"=>$_POST['document_number'],
   ":description"=>$_POST['description'],
   ":payment_type"=> $payment_type,
   ":status"=> $status,
   ":account_type"=> $account_type,
   ":id"=>$args['id']
));


	header("Location: /accountreceivable");
	exit;	

});

// pay the account

$app->get('/accountreceivable-pay/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


    $sql = new Sql();


	$status_account = $sql->select("select
   c.status as status 
   from accounts c
   where c.id=:id",  array(
	":id"=>$args['id']	
		
	));

	if ($status_account[0]['status'] == "PAID"){
		
	 
		echo "<script> 
		  alert('Warning! This account has already been paid !');
		  window.location.href='/accountreceivable';
		 </script>";
  
  
	}else{

		$sql2 = new Sql();

		$accountreceivable = $sql2->select("select
		c.id as id,
	   c.id_client as id_client,
	   f.name as name_client,
	   c.id_cost_center as id_cost_center,
	   cc.name as name_cost_center,
	   c.value as value,
	   c.issue_date as issue_date,
	   c.expiration_date as expiration_date,
	   c.document_number as document_number,
	   c.description as description,
	   c.payment_type as payment_type,
	   c.status as status,
	   c.account_type as account_type 
	   from accounts c, clients f, costs_center cc
	   where (c.id_client = f.id ) and (c.id_cost_center = cc.id) and
	   (c.id=:id)",  array(
		   "id"=>$args['id']
			
		));
	   

	

	 $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'accountreceivable-pay.html', [
   
	"accountreceivable" => $accountreceivable[0],
	"user_name"=> $user_name
 
     ]);
	

	}// else

 });

 // save pay account

$app->post('/accountreceivable-pay/{id}', function ($request, $response, $args) {


	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];




	$_POST["total_value"] =  str_replace(",",".", $_POST["total_value"] );
		
	$status = "PAID";


    $sql = new Sql();


	$pay_account = $sql->select(" 	
	update accounts set 
	total_value=:total_value,
	payment_date=:payment_date,
	status=:status where id=:id",  array(
	 
	   ":total_value"=>$_POST['total_value'],
	   ":payment_date"=>$_POST['payment_date'],
	   ":status"=> $status,
	   ":id"=>$args['id']	
	));

    
    header("Location: /accountreceivable");
	exit;
});

// reverse payment

$app->get('/accountreceivable-reverse/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];



	$sql = new Sql();


	$status_account = $sql->select("select
   c.status as status 
   from accounts c
   where c.id=:id",  array(
	":id"=>$args['id']	
		
	));

	if ($status_account[0]['status'] == "UNPAID"){
		
	 
		echo "<script> 
		  alert('Warning! This account has not been paid and therefore your payment cannot be reversed !');
		  window.location.href='/accountreceivable';
		 </script>";
  
  
	}else{

		$status = "UNPAID";

		$total_value = 0;
		
		
		$sql2 = new Sql();
		$reverse_account = $sql2->select(" 	
		update accounts set 
		total_value=:total_value,
		payment_date=:payment_date,
		status=:status where id=:id",  array(
		
		":total_value"=>$total_value,
		":payment_date"=>NULL,
		":status"=> $status,
		":id"=>$args['id']
		));

		header("Location: /accountreceivable");
		exit;	


	}//else

	
 });

//delete
$app->get('/accountreceivable/{id}/delete', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];



    $sql = new Sql();


    $delete_account = $sql->select("delete  from accounts
    where id=:id", array(
      ":id"=>$args['id'] 
    ));
  
    header("Location: /accountreceivable");
	exit;
 
 });

 //------------------ CASH FLOW ------------

 //list
$app->get('/cashflow', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];



	$sql = new Sql();
	$sql1 = new Sql();
	$sql2 = new Sql();
    
	$cashflow = $sql->select("select distinct
	c.id as id,
	c.description as description,
	c.document_number as document_number,
	DATE_FORMAT(c.expiration_date,'%d/%m/%Y') as expiration_date,
	c.total_value as total_value,
	DATE_FORMAT(c.payment_date,'%d/%m/%Y') as payment_date,
	c.account_type as account_type
	from accounts c 
	where(c.status='PAID')
	order by c.id asc");


	$sum_accounts_incoming = $sql1->select("select distinct 
   sum(accounts.total_value) as total_value
   from accounts
   where((accounts.account_type ='INCOMING') and (accounts.status='PAID') )");

   $sum_accounts_outgoing = $sql1->select("select distinct 
   sum(accounts.total_value) as total_value
   from accounts
   where((accounts.account_type ='OUTGOING') and (accounts.status='PAID') )");


 
	 $view = Twig::fromRequest($request);
 
 
	 return $view->render($response, 'cashflow.html', [
	
			 "cashflow" => $cashflow,
			 "sum_accounts_incoming" => $sum_accounts_incoming,
			 "sum_accounts_outgoing" => $sum_accounts_outgoing,
			 "user_name"=> $user_name


 
	 ]);
 });

//------------- REPORT ----------------
$app->get('/report', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


	
	 $view = Twig::fromRequest($request);
 
 
	 return $view->render($response, 'report.html', [
	    "user_name"=> $user_name
	 ]);
 });

 
$app->post('/report', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


	
	// $aux_begin = $_POST['begin_date'];
	// $aux_end = $_POST['end_date'];

	// $convertido_begin =  strtotime($aux_begin);
	// $convertido_end =  strtotime($aux_end);

	// $begin = date("d/m/Y", $convertido_begin);
	// $end = date("d/m/Y", $convertido_end);

	switch($_POST['report_type']){

				case 'sales':
										
					$sql = new Sql();
					$sql2 = new Sql();


					$sales = $sql->select("select v.id as id, v.value_sale as value_sale, v.percentage_discount
					as percentage_discount,
					FORMAT(((v.value_sale * v.percentage_discount)/100),2) as value_discount_reais,
					v.final_value_after_discount
					as final_value_after_discount,v.sale_type as sale_type,
					DATE_FORMAT(v.date_sale,'%d/%m/%Y') as date_sale,
					v.time_sale as time_sale,
					v.quantity_items as quantity_items,
					c.name as name_client,
					fp.name as name_payment_method,
					cc.name as name_cost_center
					from
					sales v, clients c, costs_center cc,
					payment_methods fp
					where
					(v.id_client = c.id) and 
					(v.id_cost_center = cc.id) and
					(v.id_payment_method =fp.id) and
					(v.date_sale BETWEEN :begin_date  AND :end_date) order by v.date_sale desc", array(
							":begin_date"=>$_POST['begin_date'],
							":end_date"=>$_POST['end_date']
						
						));




					$sales_value = $sql2->select("select
					SUM(v.final_value_after_discount) as total_value 
					from
					sales v
					where v.date_sale BETWEEN :begin_date  AND :end_date", array(
							":begin_date"=>$_POST['begin_date'],
							":end_date"=>$_POST['end_date']
					
					));
							
					
					$period = array("begin" => convert_date_to_brazilian_format($_POST['begin_date']),"end" =>convert_date_to_brazilian_format($_POST['end_date']));



					$view = Twig::fromRequest($request);
 
 
					return $view->render($response, 'report-sales.html', [

						"sales"=>$sales,
						"period"=>$period,
						"sales_value"=>$sales_value,
						"user_name"=> $user_name
					
					]);


			break; //sales

			case 'purchases';
					$sql = new Sql();
					$sql2 = new Sql();

				

					$purchases = $sql->select("select v.id as id, v.value_purchase as value_purchase, v.percentage_discount
					as percentage_discount,
					FORMAT(((v.value_purchase * v.percentage_discount)/100),2) as value_discount_reais,
					v.final_value_after_discount
					as final_value_after_discount,v.purchase_type as purchase_type,
					DATE_FORMAT(v.date_purchase,'%d/%m/%Y') as date_purchase,
					v.time_purchase as time_purchase,
					v.quantity_items as quantity_items,
					c.name as name_supplier,
					fp.name as name_payment_method,
					cc.name as name_cost_center
					from
					purchases v, suppliers c, costs_center cc,
					payment_methods fp
					where
					(v.id_supplier = c.id) and 
					(v.id_cost_center = cc.id) and
					(v.id_payment_method =fp.id) and
					(v.date_purchase BETWEEN :begin_date  AND :end_date) order by v.date_purchase desc", array(
							":begin_date"=>$_POST['begin_date'],
							":end_date"=>$_POST['end_date']
						
						));

					


					$purchases_value = $sql2->select("select
					SUM(v.final_value_after_discount) as total_value 
					from
					purchases v
					where v.date_purchase BETWEEN :begin_date  AND :end_date", array(
							":begin_date"=>$_POST['begin_date'],
							":end_date"=>$_POST['end_date']
					
					));



					$period = array("begin" => convert_date_to_brazilian_format($_POST['begin_date']),"end" =>convert_date_to_brazilian_format($_POST['end_date']));

					
					$view = Twig::fromRequest($request);
 
 
					return $view->render($response, 'report-purchases.html', [

						"purchases"=>$purchases,
						"period"=>$period,
						"purchases_value"=>$purchases_value,
						"user_name"=> $user_name
					
					]);



			break; //purchases

			case 'account_payable_unpaid';

					$sql = new Sql();
					$sql2 = new Sql();

			        $accountpayable = $sql->select("select 
								c.id as id,
								c.description as description,
								f.name as name_supplier,
								c.document_number as document_number,
								DATE_FORMAT(c.expiration_date,'%d/%m/%Y') as expiration_date,
								c.value as value,
								c.total_value as total_value,
								DATE_FORMAT(c.payment_date,'%d/%m/%Y') as payment_date,
								c.status as status


								from accounts c, suppliers f 
								where((c.id_supplier = f.id) 
								and (c.account_type = 'OUTGOING') and (c.status = 'UNPAID') 
								and  (c.expiration_date BETWEEN :begin_date  AND :end_date))
								order by c.expiration_date desc", array(
							":begin_date"=>$_POST['begin_date'],
							":end_date"=>$_POST['end_date']
						
						));



						$value_accountpayable = $sql2->select("select
					SUM(v.value) as total_value 
					from
					accounts v
					where (v.account_type = 'OUTGOING') and (v.status = 'UNPAID')    and  
					(v.expiration_date BETWEEN :begin_date  AND :end_date)", array(
							":begin_date"=>$_POST['begin_date'],
							":end_date"=>$_POST['end_date']
					
					));


					$period = array("begin" => convert_date_to_brazilian_format($_POST['begin_date']),"end" =>convert_date_to_brazilian_format($_POST['end_date']));


					$view = Twig::fromRequest($request);
 
 
					return $view->render($response, 'report-accountpayable-unpaid.html', [

						"accountpayable"=>$accountpayable,
						"period"=>$period,
						"value_accountpayable"=>$value_accountpayable,
						"user_name"=> $user_name
					
					]);			
				

			break;

			case 'account_payable_paid';

						$sql = new Sql();
						$sql2 = new Sql();

						$accountpayable = $sql->select("select 
								c.id as id,
								c.description as description,
								f.name as name_supplier,
								c.document_number as document_number,
								DATE_FORMAT(c.expiration_date,'%d/%m/%Y') as expiration_date,
								c.value as value,
								c.total_value as total_value,
								DATE_FORMAT(c.payment_date,'%d/%m/%Y') as payment_date,
								c.status as status


								from accounts c, suppliers f 
								where((c.id_supplier = f.id) 
								and (c.account_type = 'OUTGOING') and (c.status = 'PAID') 
								and  (c.expiration_date BETWEEN :begin_date  AND :end_date))
								order by c.expiration_date desc", array(
							":begin_date"=>$_POST['begin_date'],
							":end_date"=>$_POST['end_date']
						
						));


						$value_accountpayable = $sql2->select("select
						SUM(v.total_value) as total_value 
						from
						accounts v
						where (v.account_type = 'OUTGOING') and (v.status = 'PAID')    and  
						(v.expiration_date BETWEEN :begin_date  AND :end_date)", array(
								":begin_date"=>$_POST['begin_date'],
								":end_date"=>$_POST['end_date']
						
						));

						
	

						$period = array("begin" => convert_date_to_brazilian_format($_POST['begin_date']),"end" =>convert_date_to_brazilian_format($_POST['end_date']));

						$view = Twig::fromRequest($request);
 
 
						return $view->render($response, 'report-accountpayable-paid.html', [

						"accountpayable"=>$accountpayable,
						"period"=>$period,
						"value_accountpayable"=>$value_accountpayable,
						"user_name"=> $user_name
					
					]);

			break;

			case 'account_receivable_unpaid';

					$sql = new Sql();
					$sql2 = new Sql();

					$accountreceivable = $sql->select("select 
								c.id as id,
								c.description as description,
								f.name as name_client,
								c.document_number as document_number,
								DATE_FORMAT(c.expiration_date,'%d/%m/%Y') as expiration_date,
								c.value as value,
								c.total_value as total_value,
								DATE_FORMAT(c.payment_date,'%d/%m/%Y') as payment_date,
								c.status as status


								from accounts c, clients f 
								where((c.id_client = f.id) 
								and (c.account_type = 'INCOMING') and (c.status = 'UNPAID') 
								and  (c.expiration_date BETWEEN :begin_date  AND :end_date))
								order by c.expiration_date desc", array(
							":begin_date"=>$_POST['begin_date'],
							":end_date"=>$_POST['end_date']
						
						));

					


						$value_accountreceivable = $sql2->select("select
					SUM(v.value) as total_value 
					from
					accounts v
					where (v.account_type = 'INCOMING') and (v.status = 'UNPAID')    and  
					v.expiration_date BETWEEN :begin_date  AND :end_date", array(
							":begin_date"=>$_POST['begin_date'],
							":end_date"=>$_POST['end_date']
					
					));

					

					$period = array("begin" => convert_date_to_brazilian_format($_POST['begin_date']),"end" =>convert_date_to_brazilian_format($_POST['end_date']));

					
					$view = Twig::fromRequest($request);
 
 
						return $view->render($response, 'report-accountreceivable-unpaid.html', [

						"accountreceivable"=>$accountreceivable,
						"period"=>$period,
						"value_accountreceivable"=>$value_accountreceivable,
						"user_name"=> $user_name
					
					]);
			   

			break;

			case 'account_receivable_paid';

					$sql = new Sql();
					$sql2 = new Sql();

					$accountreceivable = $sql->select("select 
								c.id as id,
								c.description as description,
								f.name as name_client,
								c.document_number as document_number,
								DATE_FORMAT(c.expiration_date,'%d/%m/%Y') as expiration_date,
								c.value as value,
								c.total_value as total_value,
								DATE_FORMAT(c.payment_date,'%d/%m/%Y') as payment_date,
								c.status as status


								from accounts c, clients f 
								where((c.id_client = f.id) 
								and (c.account_type = 'INCOMING') and (c.status = 'PAID') 
								and  (c.expiration_date BETWEEN :begin_date  AND :end_date))
								order by c.expiration_date desc", array(
							":begin_date"=>$_POST['begin_date'],
							":end_date"=>$_POST['end_date']
						
						));



						$value_accountreceivable = $sql2->select("select
					SUM(v.total_value) as total_value 
					from
					accounts v
					where (v.account_type = 'INCOMING') and (v.status = 'PAID')    and  
					v.expiration_date BETWEEN :begin_date  AND :end_date", array(
							":begin_date"=>$_POST['begin_date'],
							":end_date"=>$_POST['end_date']
					
					));

					

					$period = array("begin" => convert_date_to_brazilian_format($_POST['begin_date']),"end" =>convert_date_to_brazilian_format($_POST['end_date']));

					
					$view = Twig::fromRequest($request);
 
 
						return $view->render($response, 'report-accountreceivable-unpaid.html', [

						"accountreceivable"=>$accountreceivable,
						"period"=>$period,
						"value_accountreceivable"=>$value_accountreceivable,
						"user_name"=> $user_name
					
					]);
			   

			break;

			case 'cashflow';
			
					$sql = new Sql();
					$sql1 = new Sql();
					$sql2 = new Sql();
						
					$cashflow = $sql->select("select 
					c.id as id,
					c.description as description,
					c.document_number as document_number,
					DATE_FORMAT(c.expiration_date,'%d/%m/%Y') as expiration_date,
					c.total_value as total_value,
					DATE_FORMAT(c.payment_date,'%d/%m/%Y') as payment_date,
					c.account_type as account_type
					from accounts c 
					where(c.status='PAID')
					and  (c.payment_date BETWEEN :begin_date  AND :end_date)
										order by c.payment_date desc", array(
									":begin_date"=>$_POST['begin_date'],
									":end_date"=>$_POST['end_date']
								
								));

			      


				$sum_accounts_incoming = $sql1->select("select 
				sum(accounts.total_value) as total_value
				from accounts
				where(accounts.account_type ='INCOMING') and (accounts.status='PAID') 
				and  (accounts.payment_date BETWEEN :begin_date  AND :end_date)", array(
									":begin_date"=>$_POST['begin_date'],
									":end_date"=>$_POST['end_date']
								
								));



				$sum_accounts_outgoing = $sql2->select("select 
				sum(accounts.total_value) as total_value
				from accounts
				where(accounts.account_type ='OUTGOING') and (accounts.status='PAID') 
				and  (accounts.payment_date BETWEEN :begin_date  AND :end_date)", array(
					":begin_date"=>$_POST['begin_date'],
					":end_date"=>$_POST['end_date']
				
				));

				


				//$saldo = (double)$sum_accounts_incoming[0]['total_value'] - (double)$sum_accounts_outgoing[0]['total_value'];


				$period = array("begin" => convert_date_to_brazilian_format($_POST['begin_date']),"end" =>convert_date_to_brazilian_format($_POST['end_date']));

					
					$view = Twig::fromRequest($request);
 
 
						return $view->render($response, 'report-cashflow.html', [

						"cashflow"=>$cashflow,
						"period"=>$period,
						"sum_accounts_incoming"=>$sum_accounts_incoming,
						"sum_accounts_outgoing"=>$sum_accounts_outgoing,
						"user_name"=> $user_name
					
					]);

					
			break;



	}//switch

});

//----------------- LOGIN --------------

$app->get('/login', function ($request, $response, $args) {	

	$view = Twig::fromRequest($request);


    return $view->render($response, 'login.html', [
		    "msg_return" =>"",
   			"header"=> false,
   			"footer"=> false
            
    ]);
	
});


$app->post('/login', function($request, $response, $args) {


	$sql = new Sql();

	$results = $sql->select("SELECT * FROM users WHERE login = :LOGIN", array(
		 ":LOGIN"=>$_POST["login"]
	));

     // user not found
	if (count($results)=== 0)
	{
			//$_SESSION['msg'] = "username or password is invalid!";

			//$_SESSION['msg'] = "<p style='color: #ff0000'> username or password is invalid!</p>";

			$_SESSION['msg'] =	'<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h5><i class="icon fas fa-ban"></i> Alert!</h5>
			username or password is invalid!
			</div>';

			$view = Twig::fromRequest($request);


			return $view->render($response, 'login.html', [
				"msg_return" =>$_SESSION['msg'],
				"header"=> false,
				"footer"=> false
				
		]);

	} else{
		//user found!

		if(password_verify($_POST["password"], $results[0]["password"])){
			//correct username and password

			$_SESSION['User'] = $results[0]["name"];

			$_SESSION['Access'] = $results[0]["access"];

			$_SESSION['User_id'] = $results[0]["id"];


			header("Location: /");
			exit;


		}else{
			//user is correct but password is incorrect 

			echo "<script> 
				alert('Warning! username or password is invalid!');
				window.location.href='/login';
	   			</script>";
  
	   exit;

		}
	}
	
});

$app->get('/logout', function ($request, $response, $args) {

	unset($_SESSION['msg'],$_SESSION['User'],$_SESSION['Access'],$_SESSION['User_id']);

	header("Location: /login");
			exit;

 });

 //----------------- USERS --------------

 $app->get('/users', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];


// 	echo "<script>
// 	alert('Warning! In this demo version it is not possible to manage users');
// 	window.location.href='/';
//    </script>";

// 	exit;
 

//only users with administrator privileges
// can manage users

if($_SESSION['Access'] !== 'Admin'){
	header("Location: /");
	exit;
}


	$sql = new Sql();
 
	$users = $sql->select("select * from users");
 
	 $view = Twig::fromRequest($request);
 
 
	 return $view->render($response, 'users.html', [
	
			 "users" => $users,
			 "user_name"=> $user_name
 
	 ]);
 });
 
 $app->get('/users/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];

	//only users with administrator privileges
// can manage users

if($_SESSION['Access'] !== 'Admin'){
	header("Location: /");
	exit;
}

 
	$view = Twig::fromRequest($request);

	return $view->render($response, 'users-create.html', [

		"user_name"=> $user_name
	]);
});

//save create
$app->post('/users/create', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];

	//only users with administrator privileges
// can manage users

if($_SESSION['Access'] !== 'Admin'){
	header("Location: /");
	exit;
}


  	//the login is unique

	$sql = new Sql();
	$count_logins = $sql->select(" select count(*) as qty from users
	where login=:login",  array(
		":login"=>$_POST["login"]
		
	));

	if ($count_logins[0]['qty'] > 0){
	
 
		echo "<script> 
		  alert('Warning! This login is already in use. Choose another.');
		  window.location.href='/users/create';
		 </script>";

		 exit;
  
	   }



	   $sql2 = new Sql();
	   $insert_usuario = $sql2->select(" 
	   insert into users(name,login,password,access,email)
	   values(:name,:login,:password,:access,:email)",  array(
		   ":name"=>$_POST["name"],
		   ":login"=>$_POST["login"],
		   ":password"=>password_hash($_POST["password"], PASSWORD_DEFAULT, ['cost'=>12]),
		   ":access"=>$_POST["access"],
		   ":email"=>$_POST["email"]
		   
	   ));
	  
	   header("Location: /users");
	exit;


});

//  update
$app->get('/users/{id}', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in

		header("Location: /login");
		exit;
	}

	$user_name = $_SESSION['User'];

		//only users with administrator privileges
	// can manage users

	if($_SESSION['Access'] !== 'Admin'){
		header("Location: /");
		exit;
	}


    $sql = new Sql();

    $user = $sql->select("select * from users
	  where id=:id", array(
		":id"=>$args['id']	
	));
 
     $view = Twig::fromRequest($request);
 
 
     return $view->render($response, 'users-update.html', [
             "user" => $user[0],
			 "user_name"=> $user_name
 
     ]);
 });

 //save update
$app->post('/users/{id}', function ($request, $response, $args) {

//	It is not possible to change the user's password. 
//	only the user himself can change his password


if (!isset($_SESSION['User'])){
	//user not logged in

	header("Location: /login");
	exit;
}

$user_name = $_SESSION['User'];

	//only users with administrator privileges
// can manage users

if($_SESSION['Access'] !== 'Admin'){
	header("Location: /");
	exit;
}

//checks if the login entered belongs to another user
$sql = new Sql();
$count_logins = $sql->select(" select count(*) as qty from users
where (login=:login) and (id !=:id) ",  array(
	":login"=>$_POST["login"],
	":id"=>$args['id']
	
));



if ($count_logins[0]['qty'] > 0){


	echo "<script> 
	  alert('Warning! This login is already in use. Choose another.');
	  window.location.href='/users';
	 </script>";

	 exit;

   }


   $sql2 = new Sql();
	$qtde_logins = $sql2->select("
	 update users set name=:name,login=:login,access=:access,
	 email=:email where id=:id",  array(

		":name"=>$_POST["name"],
		":login"=>$_POST["login"],
		":access"=>$_POST["access"],
		":email"=>$_POST["email"],
		":id"=>$args['id']
		
	));

    
    header("Location: /users");
	exit;
});

// delete

$app->get('/users/{id}/delete', function ($request, $response, $args) {


	if (!isset($_SESSION['User'])){
		//user not logged in
	
		header("Location: /login");
		exit;
	}
	
	$user_name = $_SESSION['User'];
	
		//only users with administrator privileges
	// can manage users
	
	if($_SESSION['Access'] !== 'Admin'){
		header("Location: /");
		exit;
	}
	

    $sql = new Sql();


    $sql->select("delete  from users
    where id=:id", array(
      ":id"=>$args['id'] 
    ));
  
    header("Location: /users");
	exit;
 
 });

 //change password

$app->get('/users-pass', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in
	
		header("Location: /login");
		exit;
	}
	
	$user_name = $_SESSION['User'];


	$sql = new Sql();

    $user = $sql->select("select * from users
	  where id=:id", array(
		":id"=>$_SESSION['User_id']	
	));
	
 
	$view = Twig::fromRequest($request);

	return $view->render($response, 'users-password.html', [

		"user" => $user[0],
		"user_name"=> $user_name
   
	]);
});
//save new password
// each user changes his own password
$app->post('/users-pass', function ($request, $response, $args) {

	if (!isset($_SESSION['User'])){
		//user not logged in
	
		header("Location: /login");
		exit;
	}
	
	$user_name = $_SESSION['User'];



	if ($_POST['despassword'] != $_POST['despassword-confirm'] ){

		echo "<script> 
		alert('Warning! Password and confirmation are diferent.');
		window.location.href='/users-pass';
	   </script>";
  
	   exit;

	}
	
	$sql = new Sql();
	$change_pass = $sql->select("
	 update users set password=:password
	  where id=:id",  array(
        ":password"=>password_hash($_POST["despassword"], PASSWORD_DEFAULT, ['cost'=>12]),
		":id"=>$_SESSION['User_id']
		
	));

    echo "<script> 
		  alert('Password successfully changed!');
		  window.location.href='/';
		 </script>";

	exit;

});







$app->run();