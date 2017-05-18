# Man-Full-text-Search
An implementation of PostgreSQL full text search apply to linux man

The final result is a web page where you can type a request with a question or some keyword, then the website will return you the corresponding man command.

A basic exemple is : how to copy a file ? , then the website will return you the cp command and its description.

### Pre-requisites

- PostgreSQL  >= 8.3
- A PHP server

### Installation

The installation is in three steps

#### Formating man pages

The first step is to transform the man pages from their basic form (.gz) to a more human-readable version (.txt and .html)

#### Indexing Man pages

The second step is to create a table containing the man pages in postgreSQL

#### Build the web interface

The third step is to build an web page permitting to request the postgreSQL database.
