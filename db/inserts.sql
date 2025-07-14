-- Insertar categorías
INSERT INTO categorias (nombre) VALUES 
('Electrónica'),
('Ropa'),
('Alimentos');

-- Insertar productos
INSERT INTO productos (nombre, precio, categoria_id) VALUES
('Audífonos Bluetooth', 15000.00, 1), 
('Camiseta Deportiva', 35000.00, 2),    
('Chocolate Orgánico', 8500, 3),    
('Laptop Ultraligera', 1200000.00, 1),  
('Pantalones Jeans', 55000.00, 2);      

-- Insertar promociones
INSERT INTO promociones (descripcion, descuento, producto_id) VALUES
('Descuento de verano en camiseta deportiva', 15.00, 2),
('Promo por lanzamiento de audífonos', 20.00, 1);
