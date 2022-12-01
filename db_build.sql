DROP TABLE IF EXISTS lineitems;
DROP TABLE IF EXISTS invoices;
DROP TABLE IF EXISTS stock;
DROP TABLE IF EXISTS customers;

CREATE TABLE customers (
	id bigint unsigned NOT NULL AUTO_INCREMENT primary key,
	name varchar(50) NOT NULL,
	email varchar(319), 
	phone varchar(15), 
	address varchar(100)
);
CREATE TABLE stock (
	id bigint unsigned NOT NULL AUTO_INCREMENT primary key,
	name varchar(250) NOT NULL,
	current_price decimal(10, 2) NOT NULL,
	qty int NOT NULL CHECK(qty > 0)
);
CREATE TABLE invoices (
	id bigint unsigned NOT NULL AUTO_INCREMENT primary key,
	label varchar(250) NOT NULL,
	created datetime default current_timestamp,
	cleared BOOLEAN NOT NULL,
	customer_id bigint unsigned,
    CONSTRAINT fk_invoice_customer FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE SET NULL
);
CREATE TABLE lineitems (
	stock_id bigint unsigned,
	invoice_id bigint unsigned NOT NULL,
	label varchar(250),
	qty int NOT NULL CHECK(qty > 0),
	price decimal(10, 2) NOT NULL,
	CONSTRAINT fk_stock FOREIGN KEY (stock_id) REFERENCES stock (id) ON DELETE SET NULL,
	CONSTRAINT fk_invoice FOREIGN KEY (invoice_id) REFERENCES invoices (id) ON DELETE CASCADE
)
