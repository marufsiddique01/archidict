-- Dummy data for ArchiDict database
-- This file adds sample terms, term relationships, and newsletters

-- Architecture Terms
INSERT INTO `terms` (`name`, `slug`, `definition`, `image`) VALUES
('Arch', 'arch', 'A curved structure spanning an opening, designed to support the weight of the structure above it. Common types include round, pointed, and flat arches.', 'arch.jpg'),
('Buttress', 'buttress', 'A projecting support built against a wall to strengthen or reinforce it, especially one designed to resist the lateral force of an arch, roof, or vault.', 'buttress.jpg'),
('Cornice', 'cornice', 'The uppermost section of moldings along the top of a wall or just below a roof, projecting outward to create a decorative border and shed water.', 'cornice.jpg'),
('Dome', 'dome', 'A hemispherical roof or ceiling structure, often constructed over a circular or polygonal area. Domes are prevalent in various architectural styles including Byzantine, Islamic, and Neoclassical.', 'dome.jpg'),
('Entablature', 'entablature', 'The horizontal superstructure that lies directly above the columns in classical architecture, consisting of the architrave, frieze, and cornice.', 'entablature.jpg'),
('Façade', 'facade', 'The exterior face or front of a building, often given special architectural treatment. The facade typically provides an opportunity for artistic expression and establishes the visual identity of the structure.', 'facade.jpg'),
('Gargoyle', 'gargoyle', 'A sculpted grotesque figure with a spout designed to convey water from a roof away from the side of a building, preventing rainwater from running down masonry walls. Common in Gothic architecture.', 'gargoyle.jpg'),
('Hipped Roof', 'hipped-roof', 'A roof with sloped sides and ends meeting at inclined edges or hips, as opposed to a gable roof which has vertical ends.', 'hipped-roof.jpg'),
('Ionic Order', 'ionic-order', 'One of the three orders of classical Greek architecture, characterized by columns with scroll-shaped ornaments (volutes) on the capital.', 'ionic-order.jpg'),
('Jamb', 'jamb', 'The vertical sides of a doorway, window, or other opening in a wall that support the lintel or arch above.', 'jamb.jpg'),
('Keystone', 'keystone', 'The central wedge-shaped stone at the crown of an arch that locks the other pieces in place.', 'keystone.jpg'),
('Lintel', 'lintel', 'A horizontal beam that spans the opening of a door or window and carries the weight of the wall above it.', 'lintel.jpg'),
('Mezzanine', 'mezzanine', 'An intermediate floor between main floors of a building, typically not counted as a separate story. Often features a lower ceiling and overlooks the floor below.', 'mezzanine.jpg'),
('Narthex', 'narthex', 'An entrance hall or porch leading to the nave of a church. In early Christian and Byzantine architecture, it was the portion of a basilica reserved for catechumens and penitents.', 'narthex.jpg'),
('Oculus', 'oculus', 'A circular opening in a wall or dome, often used to admit light. The most famous example is the oculus at the top of the Pantheon dome in Rome.', 'oculus.jpg'),
('Parapet', 'parapet', 'A low wall or barrier at the edge of a roof, terrace, balcony, walkway, or other structure designed for protection.', 'parapet.jpg'),
('Quoin', 'quoin', 'The external corner of a building, often emphasized decoratively with large stones or brickwork. Quoins can be structural or purely decorative elements.', 'quoin.jpg'),
('Rotunda', 'rotunda', 'A round building or room covered by a dome, often used for important public buildings like legislative chambers or memorial halls.', 'rotunda.jpg'),
('Spandrel', 'spandrel', 'The triangular space between the curve of an arch and the rectangular frame enclosing it, or the space between adjacent arches in a series.', 'spandrel.jpg'),
('Tracery', 'tracery', 'The ornamental stonework that supports the glass in a Gothic window, formed from geometrical patterns of bars, mullions, and ribs.', 'tracery.jpg'),
('Undercroft', 'undercroft', 'A cellar or storage room often built partly or entirely underground beneath a building, particularly in medieval ecclesiastical architecture.', 'undercroft.jpg'),
('Vault', 'vault', 'An arched structure of masonry forming a ceiling or roof. Common types include barrel vaults, groin vaults, and rib vaults, widely used in Romanesque and Gothic architecture.', 'vault.jpg'),
('Wainscot', 'wainscot', 'A wooden paneling that lines the lower part of the walls of a room, originally used to help insulate rooms from the cold. Often decorative in modern applications.', 'wainscot.jpg'),
('Xyst', 'xyst', 'In ancient Greek architecture, a covered portico or colonnade where athletes trained during inclement weather.', 'xyst.jpg'),
('Ziggurat', 'ziggurat', 'A rectangular stepped tower that formed part of an ancient Mesopotamian temple complex. The ziggurat was a terraced pyramid with successively receding stories.', 'ziggurat.jpg');

-- Term relationships
-- Arches are related to keystone, vault, and spandrel
INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'arch' AND b.slug = 'keystone';

INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'arch' AND b.slug = 'vault';

INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'arch' AND b.slug = 'spandrel';

-- Keystone is related to arch
INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'keystone' AND b.slug = 'arch';

-- Dome is related to rotunda and oculus
INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'dome' AND b.slug = 'rotunda';

INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'dome' AND b.slug = 'oculus';

-- Oculus is related to dome
INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'oculus' AND b.slug = 'dome';

-- Vault is related to arch and buttress
INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'vault' AND b.slug = 'arch';

INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'vault' AND b.slug = 'buttress';

-- Buttress is related to vault
INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'buttress' AND b.slug = 'vault';

-- Entablature is related to cornice
INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'entablature' AND b.slug = 'cornice';

-- Cornice is related to entablature
INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'cornice' AND b.slug = 'entablature';

-- Lintel is related to jamb
INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'lintel' AND b.slug = 'jamb';

-- Jamb is related to lintel
INSERT INTO `term_relationships` (`term_id`, `related_term_id`) 
SELECT a.id, b.id FROM terms a, terms b WHERE a.slug = 'jamb' AND b.slug = 'lintel';

-- Add sample newsletters
INSERT INTO `newsletters` (`title`, `description`, `file_path`) VALUES
('Contemporary Architectural Trends 2025', 'Explore the latest trends in sustainable architecture and innovative building materials.', 'architecture_trends_2025.pdf'),
('Classical Architecture Through the Ages', 'A comprehensive guide to the evolution of classical architectural elements from Ancient Greece to modern times.', 'classical_architecture_guide.pdf'),
('Urban Design Principles for Modern Cities', 'Discover how urban planning and architectural design are shaping the future of metropolitan areas.', 'urban_design_principles.pdf'),
('Sustainable Building Materials in 2025', 'Analysis of eco-friendly materials and their application in contemporary architectural projects.', 'sustainable_materials_2025.pdf'),
('Gothic Revival: Influence on Modern Architecture', 'Learn how Gothic architectural elements continue to inspire contemporary designers.', 'gothic_revival_influence.pdf');
