USE CellProviderCompany;

CREATE TABLE CellProviderCompany
(
	serviceProviderID INT unsigned NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    PRIMARY KEY (serviceProviderID));