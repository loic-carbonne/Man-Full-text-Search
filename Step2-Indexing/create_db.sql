CREATE TABLE pages(
    nom VARCHAR PRIMARY KEY,
    texte VARCHAR,
    texte_html VARCHAR,
    texte_vectorise tsvector
);
CREATE INDEX idx_vecteur ON pages USING gin (texte_vectorise);
