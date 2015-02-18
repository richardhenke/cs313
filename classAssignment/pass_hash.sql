CREATE TABLE user 
(	user_id             INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL 
	, username          VARCHAR(100)                            NOT NULL
	, password          VARCHAR(255)                            NOT NULL
);