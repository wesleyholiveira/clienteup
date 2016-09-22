<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

//$empresa = new ClienteUp\Model\Entities\Empresa();
//$empresa->setNome('Manázius');
//$empresa->setFoto('foto1.jpg');
//$empresa->setCategoria('Informática');

//$em->persist($empresa);
//$em->flush();

$cliente = $em->find('ClienteUp\Model\Entities\Cliente', 1);
$empresa = $em->find('ClienteUp\Model\Entities\Empresa', 1);
$cupom = $em->find('ClienteUp\Model\Entities\Cupom', 'AAA123456AA04');

#$cupom = new ClienteUp\Model\Entities\Cupom();
#$cupom->setCodigo('AAA123456AA05');
#$cupom->setEmpresa($empresa);
#$cupom->setPontos(10);
#$cupom->setTitulo('Teste');
#$cupom->setImagem('foto1.jpg');

#$outroCliente = new ClienteUp\Model\Entities\Cliente();

#$outroCliente->setNomeCompleto("Musha Hadaadas Da Silva MArcos Sauro");


#$outroCliente->addCupom($cupom);


$posUp = new ClienteUp\Model\Entities\PosUp();
$posUp->setCliente($cliente);

#var_dump($posUp->getCliente());

$em->persist($posUp);
$em->flush();