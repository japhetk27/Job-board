DROP TABLE IF EXISTS job_applications;
DROP TABLE IF EXISTS advertisements;
DROP TABLE IF EXISTS companies;
DROP TABLE IF EXISTS people;
DROP TABLE IF EXISTS email_body;
/*
---------------------- Info BDD


-- Table pour stocker les sociétés
CREATE TABLE companies (
    company_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    industry VARCHAR(255),
    location VARCHAR(255),
    contact_email VARCHAR(255)
);

-- Table pour stocker les personnes
CREATE TABLE people (
    person_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    name VARCHAR(255),
    email VARCHAR(255),
    phone_number VARCHAR(20),
    password VARCHAR(255),
    company_id INT,
    FOREIGN KEY (company_id) REFERENCES companies(company_id)
);

-- Table pour stocker les e-mails
CREATE TABLE email_body (
    id_eb INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    mail VARCHAR(255),
    phone VARCHAR(10),
    type ENUM('visitor', 'job_seeker', 'employee'),
    description TEXT
);

--VARCHAR(15) pour le type

-- Table pour stocker les publicités
CREATE TABLE advertisements (
    ad_id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT,
    title VARCHAR(255),
    description TEXT,
    posted_date DATE,
    expiration_date DATE,
    salary DECIMAL(10, 2),
    location VARCHAR(255),
    work_schedule VARCHAR(255),
    FOREIGN KEY (company_id) REFERENCES companies(company_id)
);

-- Table pour stocker les informations sur une candidature
CREATE TABLE job_applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    ad_id INT,
    email_body_id INT,
    application_date DATE,
    status VARCHAR(255),
    email_sent BOOLEAN,
    FOREIGN KEY (ad_id) REFERENCES advertisements(ad_id),
    FOREIGN KEY (email_body_id) REFERENCES email_body(id_eb)
);
*/
-- Insérer des données de test

-- Table pour stocker les sociétés
INSERT INTO companies (name, industry, location, contact_email, password)
VALUES
('job_board', 'Internet', 'Global', 'contact@jobboard.com', ""),
('chomage/recherche', 'Services publics', 'Global', 'contact@chomage.com', ""),
('ABC Corp', 'Technologie', 'New York', 'contact@abccorp.com', ""),
('XYZ Industries', 'Manufacture', 'Los Angeles', 'contact@xyzindustries.com', ""),
('Global Solutions', 'Consulting', 'London', 'contact@globalsolutions.com', "");


-- Table pour stocker les personnes
INSERT INTO people (first_name, name, email, phone_number, password)
VALUES
('Admin', 'Adminson', 'admin@admin.com', '9999999999', 'adminpass'),
('John', 'Doe', 'john.doe@email.com', '1234567890', 'password123'),
('Jane', 'Smith', 'jane.smith@email.com', '5555555555', 'password456');

-- Table pour stocker les publicités
INSERT INTO advertisements (company, title, description, posted_date, expiration_date, salary, location, work_schedule, resume)
VALUES
(1, 'Software Developer Position', 'We are looking for a skilled software developer...', '2023-10-01', '2023-10-31', 75000.00, 'New York', 'Full-time', 'Ceci un resume'),
(2, 'Production Supervisor Needed', 'We are hiring a production supervisor for our facility...', '2023-10-05', '2023-11-05', 60000.00, 'Los Angeles', 'Full-time', 'un autre resume'),
(1, 'Data Analyst Internship', 'We have an exciting internship opportunity for a data analyst...', '2023-10-08', '2023-10-28', 30000.00, 'New York', 'Part-time', 'encore un autre resume');

-- Table pour stocker les e-mails
INSERT INTO email_body (person, advertisements, description)
VALUES
(2, 2, 'Description of email for John Doe'),
(3, 3, 'Description of email for Jane Smith'),
(3, 2, 'Description of email for Admin Adminson');

-- Table pour stocker les informations sur une candidature
INSERT INTO job_applications (ad, email_body, application_date, status, email_sent)
VALUES
(1, 1, '2023-10-02', 'pending', 0),
(2, 2, '2023-10-06', 'accepted', 1),
(2, 3, '2023-10-07', 'pending', 0),
(3, 1, '2023-10-09', 'pending', 0),
(1, 2, '2023-10-10', 'pending', 0);
