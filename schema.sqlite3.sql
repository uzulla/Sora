DROP TABLE IF EXISTS comment;
CREATE TABLE comment (
  id INTEGER PRIMARY KEY NOT NULL,
  user_account_id INTEGER NOT NULL ,
  post_id INTEGER NOT NULL,
  comment text NOT NULL,
  created_at text NOT NULL,
  updated_at text NOT NULL
);
DROP TABLE IF EXISTS iine;
CREATE TABLE iine (
  id INTEGER PRIMARY KEY NOT NULL,
  user_account_id INTEGER NOT NULL ,
  post_id INTEGER NOT NULL,
  created_at text NOT NULL,
  updated_at text NOT NULL
);
DROP TABLE IF EXISTS post;
CREATE TABLE post (
  id INTEGER PRIMARY KEY NOT NULL,
  user_account_id INTEGER ,
  image_filename text NOT NULL,
  comment text NOT NULL,
  created_at text NOT NULL,
  updated_at text NOT NULL
);
DROP TABLE IF EXISTS user_account;
CREATE TABLE user_account (
  id INTEGER PRIMARY KEY NOT NULL,
  login_id text NOT NULL,
  hashed_password text NOT NULL,
  updated_at text NOT NULL,
  created_at text NOT NULL
);
