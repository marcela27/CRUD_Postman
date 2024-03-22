<?php
namespace App;

require "../vendor/autoload.php";
use App\Model\Cliente;
use App\Repository\ClienteRepository;



header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') 
{
    exit(0);
}

switch($_SERVER['REQUEST_METHOD']) 
{
    case 'POST':
        $requiredFields = ['nome', 'email', 'cidade', 'estado'];
        $data = [
                    'nome' => $_POST['nome'],
                    'email' => $_POST['email'],
                    'cidade' => $_POST['cidade'],
                    'estado' => $_POST['estado'],
                ];

        if (!isValid($data, $requiredFields)) {
            http_response_code(400);
            echo json_encode(["error" => "Dados de entrada inválidos ou vazios."]);
            break;
        }

        $cliente = new Cliente();
        
        $cliente->setNome($data['nome']);
        $cliente->setEmail($data['email']);
        $cliente->setCidade($data['cidade']);
        $cliente->setEstado($data['estado']);

        $repository = new ClienteRepository();

        $success = $repository->create($cliente);
        if($success) 
        {
            http_response_code(200);
            echo json_encode(["message" => "Dados inseridos com sucesso."]);
        }else 
        {
            http_response_code(500);
            echo json_encode(["message" => "Falha ao inserir dados."]);
        }
        break;

    case 'GET':
        $cliente = new Cliente();
        $repository = new ClienteRepository();

        if(isset($_GET['id'])) 
        {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                if ($id === false) {
                    http_response_code(400); 
                    echo json_encode(['error' => 'O valor do ID fornecido não é um inteiro válido.']);
                    exit;
                } else {
                    $cliente = new Cliente();
                    $repository = new ClienteRepository();
                    $cliente->setCliente_Id($id);
                    $result = $repository->read($cliente);
                }
        }else 
        {
            $result = $repository->readAll();
        }

        if($result) 
        {
            http_response_code(200);
            echo json_encode($result);
        }else 
        {
            http_response_code(404);
            echo json_encode(["message" => "Nenhum dado encontrado."]);
        }
        break;

    case 'PUT':
        $requiredFields = ['id', 'nome', 'email', 'cidade', 'estado'];
        
        $data = json_decode(file_get_contents("php://input"));

        if (!isValidOld($data, $requiredFields)) {
            http_response_code(400);
            echo json_encode(["error" => "Dados de entrada inválidos."]);
            break;
        }

        $cliente = new Cliente();
        
        $cliente->setCliente_Id($data->id);
        $cliente->setNome($data->nome);
        $cliente->setEmail($data->email);
        $cliente->setCidade($data->cidade);
        $cliente->setEstado($data->estado);

        $repository = new ClienteRepository();

        if(empty($repository->read($cliente))){
            $success = $repository->create($cliente);
            $txt = 'inseridos';
        }else{
            $success = $repository->update($cliente);
            $txt = 'atualizados';
        }

        if($success) 
        {
            http_response_code(200);
            echo json_encode(["message" => "Dados $txt com sucesso!"]);
        }else 
        {
            http_response_code(500);
            echo json_encode(["message" => "Falha ao atualizar dados!"]);
        }
        break;

    case 'DELETE':
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }else{
            http_response_code(400); 
            echo json_encode(['error' => 'Nenhum ID informado!']);
            exit;
        }
        

        if(!is_numeric($id) && intval($id) !== $id) 
        {
            http_response_code(400); 
            echo json_encode(['error' => 'O valor do ID fornecido não é um inteiro válido!']);
            exit;
        }else 
        {
            $cliente = new Cliente();

            $repository = new ClienteRepository();
            
            $cliente->setCliente_Id($id);

            if(empty($repository->read($cliente))){
                http_response_code(400); 
                echo json_encode(['error' => 'Nenhum registro encontrado com este ID!']);
                exit;
            }else{
                $result = $repository->delete($cliente);
            }
        }

        if($result) 
        {
            http_response_code(200);
            echo json_encode(["message" => "Dados excluídos com sucesso!"]);
        }else 
        {
            http_response_code(404);
            echo json_encode(["message" => "Nenhum dado encontrado."]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método não permitido."]);
        break;
}

function isValid($data, $requiredFields) {
    foreach ($requiredFields as $field) 
    {
        if (empty($data["$field"])) 
        {
            return false;
        }
    }

    return true;
}

function isValidOld($data, $requiredFields) {
    
    foreach ($requiredFields as $field) {
        if (!isset($data->$field)) {
            return false;
        }
    }
    return true;
}