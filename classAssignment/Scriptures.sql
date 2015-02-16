create database Scriptures;
	use Scriptures;
	CREATE TABLE Scriptures (
		id int unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
		book varchar(128) NOT NULL,
		chapter int unsigned NOT NULL,
		verse int unsigned NOT NULL,
		content varchar(2056) NOT NULL
	);
	INSERT INTO Scriptures (book, chapter, verse, content) VALUES ("Ether",12,19,"And there were many whose faith was so exceedingly strong, even before Christ came, who could not be kept from within the veil, but truly saw with their eyes the things which they had beheld with an eye of faith, and they were glad.");
	INSERT INTO Scriptures (book, chapter, verse, content) VALUES ("Moroni",7,33,"And Christ hath said: If ye will have faith in me ye shall have power to do whatsoever thing is expedient in me.");
	INSERT INTO Scriptures (book, chapter, verse, content) VALUES ("Enos",1,8,"And he said unto me: Because of thy faith in Christ, whom thou hast never before heard nor seen. And many years pass away before he shall manifest himself in the flesh; wherefore, go to, thy faith hath made thee whole.");
	INSERT INTO Scriptures (book, chapter, verse, content) VALUES ("Hebrews",11,1,"Now faith is the substance of things hoped for, the evidence of things not seen.");

	CREATE TABLE Topics (
		id INT unsigned PRIMARY KEY AUTO_INCREMENT not null
		, name varchar(120) not null
	);

	CREATE TABLE Scripture_Topics (
		scripture_id INT unsigned not null
		, topics_id INT unsigned not null
		, KEY fk_scripture_topics_1 (scripture_id)
		, CONSTRAINT fk_Scripture_topics_1 FOREIGN KEY (scripture_id) REFERENCES Scriptures(id)
		, KEY fk_scripture_topics_2 (topics_id)
		, CONSTRAINT fk_scripture_topics_2 FOREIGN KEY (topics_id) REFERENCES Topics(id)
	);

	INSERT INTO Topics (
		name
		) VALUES ('Faith'), ('Sacrifice'), ('Charity');