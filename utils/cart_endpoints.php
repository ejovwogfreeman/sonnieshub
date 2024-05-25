<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// session_start();

// header('Content-Type: application/json');

// if (!isset($_SESSION['cart'])) {
//     $_SESSION['cart'] = [];
// }

// $response = ['success' => false, 'cart' => [], 'message' => ''];

// $requestPayload = file_get_contents("php://input");
// $data = json_decode($requestPayload, true);

// $action = $data['action'] ?? '';
// $productId = $data['product_id'] ?? null;
// $quantity = $data['quantity'] ?? 1;

// function fetchProduct($productId)
// {
//     // Include the database connection file
//     include('./config/db.php'); // Make sure the path is correct

//     // Check if the database connection is established
//     if (!$conn) {
//         die('Connection failed: ' . mysqli_connect_error());
//     }

//     // Use prepared statements to prevent SQL injection
//     $sql = "SELECT * FROM products WHERE product_id = ?";
//     $stmt = mysqli_prepare($conn, $sql);
//     if ($stmt === false) {
//         die('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
//     }

//     mysqli_stmt_bind_param($stmt, "s", $productId); // Assuming product_id is a string

//     // Execute the query
//     if (mysqli_stmt_execute($stmt)) {
//         $result = mysqli_stmt_get_result($stmt);

//         // Fetch the product data
//         if (mysqli_num_rows($result) > 0) {
//             $product = mysqli_fetch_assoc($result);
//             echo "Product found: ";
//             return json_decode($product);
//         } else {
//             echo "No product found with the given ID.";
//         }
//     } else {
//         echo "Error executing query: " . htmlspecialchars(mysqli_stmt_error($stmt));
//     }

//     // Close the statement and connection
//     mysqli_stmt_close($stmt);
//     mysqli_close($conn);
// }

// // // Test the function
// // fetchProduct('bmun95HTD4t6nOCW82gZ1Sm0S9Xv7F');

// function updateCart($action, $productId, $quantity)
// {
//     $cart = $_SESSION['cart'];
//     switch ($action) {
//         case 'add':
//             if (isset($cart[$productId])) {
//                 $cart[$productId]['quantity'] += $quantity;
//             } else {
//                 $product = fetchProduct($productId);
//                 if ($product) {
//                     $cart[$productId] = [
//                         'name' => $product['product_name'],
//                         'price' => $product['product_price'],
//                         'image' => $product['product_image'],
//                         'quantity' => $quantity
//                     ];
//                     // return json_encode($product);
//                 } else {
//                     return ['success' => false, 'message' => 'Product not found'];
//                 }
//             }
//             break;
//         case 'remove':
//             unset($cart[$productId]);
//             break;
//         case 'update':
//             if (isset($cart[$productId])) {
//                 $cart[$productId]['quantity'] = $quantity;
//             }
//             break;
//         case 'clear':
//             $cart = [];
//             break;
//         default:
//             return ['success' => false, 'message' => 'Invalid action'];
//     }
//     $_SESSION['cart'] = $cart;
//     return ['success' => true, 'cart' => $cart];
// }

// // if ($action && $productId !== null) {
// //     $response = updateCart($action, $productId, $quantity);
// // } else {
// //     $response['message'] = 'Action or productId missing';
// // }

// updateCart('add', 'bmun95HTD4t6nOCW82gZ1Sm0S9Xv7F', 1);

// // echo json_encode($response);

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// session_start();

// header('Content-Type: application/json');

// if (!isset($_SESSION['cart'])) {
//     $_SESSION['cart'] = [];
// }

// $response = ['success' => false, 'cart' => [], 'message' => ''];

// $requestPayload = file_get_contents("php://input");
// $data = json_decode($requestPayload, true);

// $action = $data['action'] ?? '';
// $productId = $data['product_id'] ?? null;
// $quantity = $data['quantity'] ?? 1;

// function fetchProduct($productId)
// {
//     include('./config/db.php'); // Make sure the path is correct

//     if (!$conn) {
//         die('Connection failed: ' . mysqli_connect_error());
//     }

//     $sql = "SELECT * FROM products WHERE product_id = ?";
//     $stmt = mysqli_prepare($conn, $sql);
//     if ($stmt === false) {
//         die('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
//     }

//     mysqli_stmt_bind_param($stmt, "s", $productId);

//     if (mysqli_stmt_execute($stmt)) {
//         $result = mysqli_stmt_get_result($stmt);

//         if (mysqli_num_rows($result) > 0) {
//             $product = mysqli_fetch_assoc($result);
//             mysqli_stmt_close($stmt);
//             mysqli_close($conn);
//             return $product; // Return the product data
//         } else {
//             mysqli_stmt_close($stmt);
//             mysqli_close($conn);
//             return null; // No product found
//         }
//     } else {
//         echo "Error executing query: " . htmlspecialchars(mysqli_stmt_error($stmt));
//         mysqli_stmt_close($stmt);
//         mysqli_close($conn);
//         return null;
//     }
// }

// function updateCart($action, $productId, $quantity)
// {
//     $cart = $_SESSION['cart'];
//     switch ($action) {
//         case 'add':
//             if (isset($cart[$productId])) {
//                 $cart[$productId]['quantity'] += $quantity;
//             } else {
//                 $product = fetchProduct($productId);
//                 if ($product) {
//                     $cart[$productId] = [
//                         'name' => $product['product_name'],
//                         'price' => $product['product_price'],
//                         'image' => $product['product_image'],
//                         'quantity' => $quantity
//                     ];
//                 } else {
//                     return ['success' => false, 'message' => 'Product not found'];
//                 }
//             }
//             break;
//         case 'remove':
//             unset($cart[$productId]);
//             break;
//         case 'update':
//             if (isset($cart[$productId])) {
//                 $cart[$productId]['quantity'] = $quantity;
//             }
//             break;
//         case 'clear':
//             $cart = [];
//             break;
//         default:
//             return ['success' => false, 'message' => 'Invalid action'];
//     }
//     $_SESSION['cart'] = $cart;
//     return ['success' => true, 'cart' => $cart];
// }

// if ($action && $productId !== null) {
//     $response = updateCart($action, $productId, $quantity);
// } else {
//     $response['message'] = 'Action or product_id missing';
// }

// echo json_encode($response);


error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$response = ['success' => false, 'cart' => [], 'message' => ''];

$requestPayload = file_get_contents("php://input");
$data = json_decode($requestPayload, true);

error_log("Received payload: " . print_r($data, true)); // Log received data

$action = $data['action'] ?? '';
$productId = $data['product_id'] ?? null;
$quantity = $data['quantity'] ?? 1;

function fetchProduct($productId)
{
    include('./config/db.php'); // Ensure the path is correct

    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
    }

    mysqli_stmt_bind_param($stmt, "s", $productId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $product;
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return null;
        }
    } else {
        error_log("Error executing query: " . htmlspecialchars(mysqli_stmt_error($stmt)));
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return null;
    }
}

function updateCart($action, $productId, $quantity)
{
    $cart = $_SESSION['cart'];
    switch ($action) {
        case 'add':
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $product = fetchProduct($productId);
                if ($product) {
                    $cart[$productId] = [
                        'name' => $product['product_name'],
                        'price' => $product['product_price'],
                        'image' => $product['product_image'],
                        'quantity' => $quantity
                    ];
                } else {
                    return ['success' => false, 'message' => 'Product not found'];
                }
            }
            break;
        case 'remove':
            unset($cart[$productId]);
            break;
        case 'update':
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
            }
            break;
        case 'clear':
            $cart = [];
            break;
        default:
            return ['success' => false, 'message' => 'Invalid action'];
    }
    $_SESSION['cart'] = $cart;
    return ['success' => true, 'cart' => $cart];
}

if ($action && $productId !== null) {
    $response = updateCart($action, $productId, $quantity);
} else {
    $response['message'] = 'Action or product_id missing';
}

echo json_encode($response);
