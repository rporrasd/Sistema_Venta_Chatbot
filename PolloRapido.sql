use db_pollorapido;
--
-- Table structure for table `carrito`
--
CREATE TABLE `carrito` (
  `carrito_id` int(15) NOT NULL,
  `cliente_id` int(15) NOT NULL,
  `prod_id` int(15) NOT NULL,
  `cant_id` int(15) NOT NULL,
  `total` float NOT NULL,
  `flag` int(1) NOT NULL,
  `IdPedido` int NULL,
  `estado` varchar(20) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------
--
-- Table structure for table `moneda`
--
CREATE TABLE `moneda` (
  `moneda_id` int(5) NOT NULL,
  `moneda_symbol` varchar(15) NOT NULL,
  `flag` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Dumping data for table `moneda`
--
-- --------------------------------------------------------
--
-- Table structure for table `productos`
--
CREATE TABLE `productos` (
  `prod_id` int(15) NOT NULL,
  `prod_name` varchar(45) NOT NULL,
  `prod_description` text NOT NULL,
  `prod_price` float NOT NULL,
  `prod_photo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Dumping data for table `productos`
--
-- --------------------------------------------------------
--
-- Table structure for table `questions`
--
CREATE TABLE `documento` (
  `documento_id` int(5) NOT NULL,
  `documento_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Dumping data for table `questions`
--
-- --------------------------------------------------------
--
-- Table structure for table `clientes`
--
CREATE TABLE `clientes` (
  `cliente_id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `correo` varchar(100) NOT NULL DEFAULT '',
  `contraseña` varchar(32) NOT NULL DEFAULT '',
  `telefono` varchar(45) NOT NULL,
  `Dirección` varchar(100) NOT NULL,
  `documento_id` int(5) NOT NULL,
  `numeroDoc` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--
-- Dumping data for table `clientes`
--
-- --------------------------------------------------------
--
-- Table structure for table `pedido`
--
CREATE TABLE `pedido` (
  `pedido_id` int(10) NOT NULL,
  `cliente_id` int(10) NOT NULL,
  `flag` int(1) NOT NULL,
  `time_stamp` time NOT NULL,
  `precioTotal` decimal(5,2),
  `Observaciones` varchar(40),
  `delivery_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- --------------------------------------------------------
--
-- Table structure for table `pizza_admin`
--
CREATE TABLE `pizza_admin` (
  `Admin_ID` int(45) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--
-- Dumping data for table `pizza_admin`
--
-- --------------------------------------------------------
--
-- Table structure for table `cantidades`
--
CREATE TABLE `cantidades` (
  `cant_id` int(5) NOT NULL,
  `cant_value` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Dumping data for table `cantidades`
--
-- --------------------------------------------------------
-- Indexes for dumped tables
--
-- Indexes for table `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`carrito_id`);
--
-- Indexes for table `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`moneda_id`);
--
-- Indexes for table `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`documento_id`);
--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`prod_id`);
--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cliente_id`);
--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`pedido_id`);
--
-- Indexes for table `pizza_admin`
--
ALTER TABLE `pizza_admin`
  ADD PRIMARY KEY (`Admin_ID`);
--
-- Indexes for table `cantidades`
--
ALTER TABLE `cantidades`
  ADD PRIMARY KEY (`cant_id`);
--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `carrito`
--
ALTER TABLE `carrito`
  MODIFY `carrito_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `moneda`
--
ALTER TABLE `moneda`
  MODIFY `moneda_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `documento`
--
ALTER TABLE `documento`
  MODIFY `documento_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `prod_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cliente_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
  MODIFY `pedido_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `pizza_admin`
--
ALTER TABLE `pizza_admin`
  MODIFY `Admin_ID` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cantidades`
--
ALTER TABLE `cantidades`
  MODIFY `cant_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

