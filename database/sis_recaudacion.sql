-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: sis_retencion_vehicular
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actividades`
--

DROP TABLE IF EXISTS `actividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actividades` (
  `id_actividad` int(11) NOT NULL AUTO_INCREMENT,
  `detalle` text NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id_actividad`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividades`
--

LOCK TABLES `actividades` WRITE;
/*!40000 ALTER TABLE `actividades` DISABLE KEYS */;
INSERT INTO `actividades` VALUES (1,'Ingreso',5.00),(2,'Salida',0.00),(3,'Chatarrización',0.00),(4,'Actualización de documentos',10.00),(5,'Parqueadero',10.00);
/*!40000 ALTER TABLE `actividades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_registro`
--

DROP TABLE IF EXISTS `detalle_registro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_registro` (
  `id_detalle_registro` int(11) NOT NULL AUTO_INCREMENT,
  `id_actividad` int(11) NOT NULL,
  `codigo_registro` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle_registro`),
  KEY `id_actividad` (`id_actividad`),
  KEY `codigo_registro` (`codigo_registro`),
  CONSTRAINT `detalle_registro_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id_actividad`) ON UPDATE CASCADE,
  CONSTRAINT `detalle_registro_ibfk_2` FOREIGN KEY (`codigo_registro`) REFERENCES `registros` (`codigo_registro`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_registro`
--

LOCK TABLES `detalle_registro` WRITE;
/*!40000 ALTER TABLE `detalle_registro` DISABLE KEYS */;
INSERT INTO `detalle_registro` VALUES (25,1,5),(26,5,5);
/*!40000 ALTER TABLE `detalle_registro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formas_pago`
--

DROP TABLE IF EXISTS `formas_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formas_pago` (
  `id_forma_pago` int(11) NOT NULL AUTO_INCREMENT,
  `detalle` varchar(50) NOT NULL,
  PRIMARY KEY (`id_forma_pago`),
  UNIQUE KEY `detalle` (`detalle`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formas_pago`
--

LOCK TABLES `formas_pago` WRITE;
/*!40000 ALTER TABLE `formas_pago` DISABLE KEYS */;
INSERT INTO `formas_pago` VALUES (1,'Efectivo'),(3,'Tarjeta de crédito'),(4,'Tarjeta de débito'),(2,'Transferencia');
/*!40000 ALTER TABLE `formas_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `infracciones`
--

DROP TABLE IF EXISTS `infracciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `infracciones` (
  `codigo_infraccion` varchar(20) NOT NULL,
  `detalle` text NOT NULL,
  PRIMARY KEY (`codigo_infraccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `infracciones`
--

LOCK TABLES `infracciones` WRITE;
/*!40000 ALTER TABLE `infracciones` DISABLE KEYS */;
INSERT INTO `infracciones` VALUES ('INF001','Mal estacionamiento'),('INF002','No respetar el semáforo en rojo');
/*!40000 ALTER TABLE `infracciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marcas`
--

DROP TABLE IF EXISTS `marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marcas` (
  `codigo_marca` varchar(20) NOT NULL,
  `detalle` text NOT NULL,
  PRIMARY KEY (`codigo_marca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marcas`
--

LOCK TABLES `marcas` WRITE;
/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
INSERT INTO `marcas` VALUES ('MAR001','Aston Martin'),('MAR002','Mazda'),('MAR003','Mercedes Benz'),('MAR004','BMW');
/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modelos`
--

DROP TABLE IF EXISTS `modelos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modelos` (
  `codigo_modelo` varchar(20) NOT NULL,
  `detalle` text NOT NULL,
  PRIMARY KEY (`codigo_modelo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modelos`
--

LOCK TABLES `modelos` WRITE;
/*!40000 ALTER TABLE `modelos` DISABLE KEYS */;
INSERT INTO `modelos` VALUES ('MOD001','Deportivo'),('MOD002','SUV'),('MOD003','Camioneta');
/*!40000 ALTER TABLE `modelos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patios`
--

DROP TABLE IF EXISTS `patios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patios` (
  `codigo_patio` varchar(20) NOT NULL,
  `detalle` text NOT NULL,
  `direccion` text NOT NULL,
  PRIMARY KEY (`codigo_patio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patios`
--

LOCK TABLES `patios` WRITE;
/*!40000 ALTER TABLE `patios` DISABLE KEYS */;
INSERT INTO `patios` VALUES ('PAT001','Patio general','Calle Quito y 31 de Octubre'),('PAT002','Patio especial','Bolívar y Calle Quito');
/*!40000 ALTER TABLE `patios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propietarios`
--

DROP TABLE IF EXISTS `propietarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `propietarios` (
  `cedula_propietario` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`cedula_propietario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propietarios`
--

LOCK TABLES `propietarios` WRITE;
/*!40000 ALTER TABLE `propietarios` DISABLE KEYS */;
INSERT INTO `propietarios` VALUES ('1004000000','Pedro Juan','Gómez Díaz','0982525888'),('1004008887','Pedro Daniel','Gómez Castillo','0982525111');
/*!40000 ALTER TABLE `propietarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registros`
--

DROP TABLE IF EXISTS `registros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registros` (
  `codigo_registro` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pagado','pendiente') NOT NULL,
  `id_forma_pago` int(11) DEFAULT NULL,
  `placa_vehiculo` varchar(10) NOT NULL,
  `cedula_responsable` varchar(20) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha_retener_hasta` date NOT NULL,
  PRIMARY KEY (`codigo_registro`),
  KEY `id_forma_pago` (`id_forma_pago`),
  KEY `placa_vehiculo` (`placa_vehiculo`),
  KEY `cedula_responsable` (`cedula_responsable`),
  CONSTRAINT `registros_ibfk_1` FOREIGN KEY (`id_forma_pago`) REFERENCES `formas_pago` (`id_forma_pago`) ON UPDATE CASCADE,
  CONSTRAINT `registros_ibfk_2` FOREIGN KEY (`placa_vehiculo`) REFERENCES `vehiculos` (`placa`) ON UPDATE CASCADE,
  CONSTRAINT `registros_ibfk_3` FOREIGN KEY (`cedula_responsable`) REFERENCES `responsables` (`cedula_responsable`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registros`
--

LOCK TABLES `registros` WRITE;
/*!40000 ALTER TABLE `registros` DISABLE KEYS */;
INSERT INTO `registros` VALUES (5,'2025-02-03 17:37:08','pagado',3,'ABC-401','9899999999',15.00,'2025-02-28');
/*!40000 ALTER TABLE `registros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsables`
--

DROP TABLE IF EXISTS `responsables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `responsables` (
  `cedula_responsable` varchar(20) NOT NULL,
  `nombres_responsable` varchar(100) NOT NULL,
  `apellidos_responsable` varchar(100) NOT NULL,
  `email_responsable` varchar(100) NOT NULL,
  PRIMARY KEY (`cedula_responsable`),
  UNIQUE KEY `email_responsable` (`email_responsable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsables`
--

LOCK TABLES `responsables` WRITE;
/*!40000 ALTER TABLE `responsables` DISABLE KEYS */;
INSERT INTO `responsables` VALUES ('9899999999','Juana María','Díaz Díaz','juanita@correo.com');
/*!40000 ALTER TABLE `responsables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador','Tiene acceso total al sistema'),(2,'Operador','Puede realizar registros y gestionar procesos limitados'),(3,'Usuario','Solo puede consultar información relevante a sus registros');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `contraseña` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `cedula` (`cedula`),
  UNIQUE KEY `correo` (`correo`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `id_rol` (`id_rol`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'admin','1111111111','Juan','Pérez','admin@correo.com','0991111111','admin321',1,'2025-01-28 23:54:37'),(2,'operador','2222222222','María','Gómez','operador@correo.com','0992222222','operador123',2,'2025-01-28 23:54:37'),(7,'1004008887','1004008887','Pedro Daniel','Gómez Castillo','pedrito@correo.com','0982525111','usuario123',3,'2025-02-01 18:33:20'),(9,'1004000000','1004000000','Pedro Juan','Gómez Díaz','juan@correo.com','0982525888','usuario123',3,'2025-02-03 17:33:36');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER encrypt_passwords
BEFORE INSERT ON usuarios
FOR EACH ROW
BEGIN
    SET NEW.contraseña = SHA2(NEW.contraseña, 256);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `vehiculos`
--

DROP TABLE IF EXISTS `vehiculos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehiculos` (
  `placa` varchar(10) NOT NULL,
  `anio` int(11) NOT NULL,
  `estado` text NOT NULL,
  `codigo_marca` varchar(20) DEFAULT NULL,
  `codigo_modelo` varchar(20) DEFAULT NULL,
  `cedula_propietario` varchar(20) DEFAULT NULL,
  `codigo_infraccion` varchar(20) DEFAULT NULL,
  `codigo_patio` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`placa`),
  KEY `codigo_marca` (`codigo_marca`),
  KEY `codigo_modelo` (`codigo_modelo`),
  KEY `cedula_propietario` (`cedula_propietario`),
  KEY `codigo_infraccion` (`codigo_infraccion`),
  KEY `codigo_patio` (`codigo_patio`),
  CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`codigo_marca`) REFERENCES `marcas` (`codigo_marca`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `vehiculos_ibfk_2` FOREIGN KEY (`codigo_modelo`) REFERENCES `modelos` (`codigo_modelo`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `vehiculos_ibfk_3` FOREIGN KEY (`cedula_propietario`) REFERENCES `propietarios` (`cedula_propietario`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `vehiculos_ibfk_4` FOREIGN KEY (`codigo_infraccion`) REFERENCES `infracciones` (`codigo_infraccion`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `vehiculos_ibfk_5` FOREIGN KEY (`codigo_patio`) REFERENCES `patios` (`codigo_patio`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehiculos`
--

LOCK TABLES `vehiculos` WRITE;
/*!40000 ALTER TABLE `vehiculos` DISABLE KEYS */;
INSERT INTO `vehiculos` VALUES ('ABC-400',2020,'Liberado','MAR004','MOD003','1004008887','INF001','PAT002'),('ABC-401',2024,'Liberado','MAR003','MOD001','1004000000','INF002','PAT002');
/*!40000 ALTER TABLE `vehiculos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-03 12:43:54
