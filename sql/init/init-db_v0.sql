CREATE DATABASE webtoonlike CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE webtoonlike;

CREATE TABLE Users (
    userID BIGINT NOT NULL AUTO_INCREMENT,
    username VARCHAR(32),
    email VARCHAR(256),
    registeredAt DATETIME,
    PRIMARY KEY (userID)
)  ENGINE=INNODB; 

CREATE TABLE Report (
    reportID BIGINT NOT NULL AUTO_INCREMENT,
    type INT,
    userID BIGINT NOT NULL,
    PRIMARY KEY (reportID),
    FOREIGN KEY (userID) REFERENCES Users(userID)
)  ENGINE=INNODB; 

CREATE TABLE TranslationProposition (
    translationPropositionID BIGINT NOT NULL AUTO_INCREMENT,
    proposedTranslation TEXT,
    PRIMARY KEY (translationPropositionID)
)  ENGINE=INNODB; 

CREATE TABLE Propose (
    translationPropositionID BIGINT NOT NULL,
    userID BIGINT NOT NULL,
    FOREIGN KEY (userID) REFERENCES Users(userID),
    FOREIGN KEY (translationPropositionID) REFERENCES TranslationProposition(translationPropositionID)
)  ENGINE=INNODB; 

CREATE TABLE Webtoons (
    webtoonID BIGINT NOT NULL AUTO_INCREMENT,
    name VARCHAR(256),
    author VARCHAR(128),
    description TEXT,
    PRIMARY KEY (webtoonID)
)  ENGINE=INNODB; 

CREATE TABLE Chapter (
    chapterID BIGINT NOT NULL AUTO_INCREMENT,
    number INT,
    title VARCHAR(256),
    webtoonID BIGINT NOT NULL,
    PRIMARY KEY (chapterID),
    FOREIGN KEY (webtoonID) REFERENCES Webtoons(webtoonID)
)  ENGINE=INNODB; 

CREATE TABLE Image (
    imageID BIGINT NOT NULL AUTO_INCREMENT,
    position INT,
    path VARCHAR(256),
    chapterID BIGINT NOT NULL,
    PRIMARY KEY (imageID),
    FOREIGN KEY (chapterID) REFERENCES Chapter(chapterID)
)  ENGINE=INNODB; 

CREATE TABLE CellPosition (
    cellPositionID BIGINT NOT NULL AUTO_INCREMENT,
    xAxis INT,
    yAxis INT,
    PRIMARY KEY (cellPositionID)
)  ENGINE=INNODB; 

CREATE TABLE AvailableLanguage (
    AvailableLanguageID VARCHAR(256) NOT NULL,
    label VARCHAR(128),
    encodingStandard VARCHAR(128),
    PRIMARY KEY (AvailableLanguageID)
)  ENGINE=INNODB; 

CREATE TABLE Cell (
    cellID BIGINT NOT NULL AUTO_INCREMENT,
    content TEXT,
    imageID BIGINT NOT NULL,
    cellPositionID BIGINT NOT NULL,
    AvailableLanguageID VARCHAR(256) NOT NULL,
    PRIMARY KEY (cellID),
    FOREIGN KEY (imageID) REFERENCES Image(imageID),
    FOREIGN KEY (cellPositionID) REFERENCES CellPosition(cellPositionID),
    FOREIGN KEY (AvailableLanguageID) REFERENCES AvailableLanguage(AvailableLanguageID)
)ENGINE=INNODB; 
