# Man-Full-text-Search
An implementation of PostgreSQL full text search apply to linux man

The final result is a web page where you can type a request with a question or some keyword, then the website will return you the corresponding man command.

A basic exemple is : how to copy a file ? , then the website will return you the cp command and its description.

### Pre-requisites

- PostgreSQL  >= 8.3
- A PHP server

### Installation

The installation is in three steps

#### Step 1 : Formating man pages

The first step is to transform the man pages from their basic nroff format to a more human-readable version (.txt and .html)
Standard location for man pages is /usr/share/man

You can find two script *mit.sh* and *mih.sh* who respectively convert man pages to .txt and .html files.
You just have to place the scripts in the same folder as the man pages and run it.
- mit.sh use groff linux command
- mih.sh use [roffit](https://github.com/bagder/roffit), a nice nroff convertor tool that you have to install before running the script

The folder *result* contains exemples of converted man files

#### Step 2 : Indexing Man pages

The second step is to create a table containing the man pages in postgreSQL

#### Step 3 : Build the web interface

The third step is to build an web page permitting to request the postgreSQL database.
