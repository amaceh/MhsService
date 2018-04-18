CREATE TABLE kuliah (
    kode_mk INT NOT NULL AUTO_INCREMENT, 
    nama_mk VARCHAR(100) NOT NULL, 
    nama_dosen VARCHAR(100) NOT NULL, 
    sks INT NOT NULL, 
    PRIMARY KEY (`kode_mk`)
) ENGINE = InnoDB;

CREATE TABLE users (
    email VARCHAR(100) NOT NULL,
    password VARCHAR(60) NOT NULL, 
    api_key VARCHAR(64) NOT NULL,
    PRIMARY KEY (`email`), 
    UNIQUE (`api_key`)
) ENGINE = InnoDB;

