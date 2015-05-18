--
-- This script removes all data from the Rietveld db.
-- Handy during development and importing data from another instance.
-- Note that only the tables are truncated here (the views will change accordingly).
--

SET FOREIGN_KEY_CHECKS=0;

TRUNCATE `category`;
TRUNCATE `item`;
TRUNCATE `itemupload`;
TRUNCATE `itemuploadfilter`;
TRUNCATE `itemuploaduploads`;
TRUNCATE `itemuploaduser`;
TRUNCATE `localization`;
TRUNCATE `namespace`;
TRUNCATE `user`;
TRUNCATE `usergroup`;
TRUNCATE `webtree`;
TRUNCATE `task`;
TRUNCATE `taskRoles`;

SET FOREIGN_KEY_CHECKS=1;