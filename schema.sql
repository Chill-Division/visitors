CREATE DATABASE visitor_signin; 
USE visitor_signin;

CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact VARCHAR(255) NOT NULL,
    company VARCHAR(255),
    visiting VARCHAR(255) NOT NULL,
    timestamp DATETIME NOT NULL,
    sign_out_timestamp DATETIME
);

CREATE TABLE terms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    term_text TEXT NOT NULL
);

-- Pre-populate terms, you can remove / modify these if you wish
INSERT INTO terms (term_text) VALUES
('I understand that as a guest, I am required to be always escorted by staff while on the premises, unless there is NO cannabis biomass on site.'),
('I acknowledge that I will not be issued any form of security clearance such as PINs or key fobs.'),
('I agree that any items I bring into the facility may be subject to search before I leave the premises.'),
('If I am a contractor, I will bring only the minimum tools necessary to perform my job and understand that toolboxes may be subject to search.'),
('I will maintain the same high level of health and hygiene standards as staff members, including wearing gloves and other PPE items as instructed.'),
('I will not access any areas containing cannabis biomass without an escort.'),
('If I need to leave a room where maintenance is being performed, I understand that I must leave with my escort and wait in a designated area.'),
('I agree to sign out and record the date and time of my departure before leaving the premises.'),
('I understand that a search of my belongings may be conducted before I depart, based on the duration of my visit, potential access to cannabis, and other relevant circumstances.'),
('I will comply with all instructions given by my escort and adhere to all facility rules and regulations.');
