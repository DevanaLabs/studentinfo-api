<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160203094915 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE oauth_access_token_scopes (id int(10) unsigned not null auto_increment, access_token_id varchar(40) not null, scope_id varchar(40) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id), KEY oauth_access_token_scopes_access_token_id_index (access_token_id), KEY oauth_access_token_scopes_scope_id_index (scope_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
        $this->addSql('CREATE TABLE oauth_access_tokens (id varchar(40) not null, session_id int(10) unsigned not null, expire_time int(11) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id), UNIQUE KEY (id,session_id), KEY oauth_access_tokens_session_id_index (session_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addSql('CREATE TABLE oauth_auth_code_scopes (id int(10) unsigned not null auto_increment, auth_code_id varchar(40) not null, scope_id varchar(40) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id), KEY oauth_auth_code_scopes_auth_code_id_index (auth_code_id), KEY oauth_auth_code_scopes_scope_id_index (scope_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
        $this->addSql('CREATE TABLE oauth_auth_codes (id varchar(40) not null, session_id int(10) unsigned not null, redirect_uri varchar(255) not null, expire_time int(11) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id), KEY oauth_auth_codes_session_id_index (session_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addSql('CREATE TABLE oauth_client_endpoints (id int(10) unsigned not null auto_increment, client_id varchar(40) not null, redirect_uri varchar(255) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id), UNIQUE KEY (client_id,redirect_uri)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
        $this->addSql('CREATE TABLE oauth_client_grants (id int(10) unsigned not null auto_increment, client_id varchar(40) not null, grant_id varchar(40) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id), KEY oauth_client_grants_client_id_index (client_id), KEY oauth_client_grants_grant_id_index (grant_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
        $this->addSql('CREATE TABLE oauth_client_scopes (id int(10) unsigned not null auto_increment, client_id varchar(40) not null, scope_id varchar(40) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id), KEY oauth_client_scopes_client_id_index (client_id), KEY oauth_client_scopes_scope_id_index (scope_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
        $this->addSql('CREATE TABLE oauth_clients (id varchar(40) not null, secret varchar(40) not null, name varchar(255) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id), UNIQUE KEY (id,secret)) ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addSql('CREATE TABLE oauth_grant_scopes (id int(10) unsigned not null auto_increment, grant_id varchar(40) not null, scope_id varchar(40) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id), KEY oauth_grant_scopes_grant_id_index (grant_id), KEY oauth_grant_scopes_scope_id_index (scope_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
        $this->addSql('CREATE TABLE oauth_grants (id varchar(40) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addSql('CREATE TABLE oauth_refresh_tokens (id varchar(40) not null, access_token_id varchar(40) not null, expire_time int(11) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (access_token_id), UNIQUE KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addSql('CREATE TABLE oauth_scopes (id varchar(40) not null, description varchar(255) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addSql('CREATE TABLE oauth_session_scopes (id int(10) unsigned not null auto_increment, session_id int(10) unsigned not null, scope_id varchar(40) not null, created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id), KEY oauth_session_scopes_session_id_index (session_id), KEY oauth_session_scopes_scope_id_index (scope_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
        $this->addSql('CREATE TABLE oauth_sessions (id int(10) unsigned not null auto_increment, client_id varchar(40) not null, owner_type enum(\'client\',\'user\') not null default \'user\', owner_id varchar(255) not null, client_redirect_uri varchar(255), created_at timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, updated_at timestamp not null default \'0000-00-00 00:00:00\', PRIMARY KEY (id), KEY oauth_sessions_client_id_owner_type_owner_id_index (client_id,owner_type,owner_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE oauth_access_token_scopes');
        $this->addSql('DROP TABLE oauth_access_tokens');
        $this->addSql('DROP TABLE oauth_auth_code_scopes');
        $this->addSql('DROP TABLE oauth_auth_codes');
        $this->addSql('DROP TABLE oauth_client_endpoints');
        $this->addSql('DROP TABLE oauth_client_grants');
        $this->addSql('DROP TABLE oauth_client_scopes');
        $this->addSql('DROP TABLE oauth_clients');
        $this->addSql('DROP TABLE oauth_grant_scopes');
        $this->addSql('DROP TABLE oauth_grants');
        $this->addSql('DROP TABLE oauth_refresh_tokens');
        $this->addSql('DROP TABLE oauth_scopes');
        $this->addSql('DROP TABLE oauth_session_scopes');
        $this->addSql('DROP TABLE oauth_sessions');
    }
}
