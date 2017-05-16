CREATE TABLE todos (
  id MEDIUMINT NOT NULL AUTO_INCREMENT,
  todo varchar(30),
  created_at timestamp not null default current_timestamp,
  updated_at timestamp not null default current_timestamp on update current_timestamp,
  deleted_at datetime NULL DEFAULT NULL,
  PRIMARY KEY(id)
  );

CREATE TABLE user_infos(
  id MEDIUMINT NOT NULL AUTO_INCREMENT,
  name varchar(30),
  pass varchar(30),
  created_at timestamp not null default current_timestamp,
  updated_at timestamp not null default current_timestamp on update current_timestamp,
  deleted_at datetime NULL DEFAULT NULL,
  PRIMARY KEY(id)
  );