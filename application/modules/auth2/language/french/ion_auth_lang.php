<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name: Ion Auth Lang - French
*
* Author: Stan
* tfspir@gmail.com
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Adjustments by ggallon
*
* Created: 03.23.2010
*
* Description: French language file for Ion Auth messages and errors
*
*/
 
// Account Creation
$lang['account_creation_successful'] = 'Compte créé avec succès';
$lang['account_creation_unsuccessful'] = 'Impossible de créer le compte';
$lang['account_creation_duplicate_email'] = 'Email déjà utilisé ou invalide';
$lang['account_creation_duplicate_username'] = 'Nom d\'utilisateur déjà utilisé ou invalide';

// TODO Please Translate
$lang['account_creation_missing_default_group'] = 'Le groupe par défaut n\'est pas configuré';
$lang['account_creation_invalid_default_group'] = 'Le nom du groupe par défaut n\'est pas valide';
 
 
// Password
$lang['password_change_successful'] = 'Le mot de passe a été changé avec succès';
$lang['password_change_unsuccessful'] = 'Impossible de changer le mot de passe';
$lang['forgot_password_successful'] = 'Mail de réinitialisation du mot de passe envoyé';
$lang['forgot_password_unsuccessful'] = 'Impossible de réinitialiser le mot de passe';
 
// Activation
$lang['activate_successful'] = 'Compte activé';
$lang['activate_unsuccessful'] = 'Impossible d\'activer le compte';
$lang['deactivate_successful'] = 'Compte désactivé';
$lang['deactivate_unsuccessful'] = 'Impossible de désactiver le compte';
$lang['activation_email_successful'] = 'Email d\'activation envoyé avec succès';
$lang['activation_email_unsuccessful'] = 'Impossible d\'envoyer le mail d\'activation';
 
// Login / Logout
$lang['login_successful'] = 'Connecté avec succès';
$lang['login_unsuccessful'] = 'Érreur lors de la connexion';
$lang['login_unsuccessful_not_active'] = 'Ce compte est inactif';
$lang['logout_successful'] = 'Déconnexion effectuée avec succès';
  
// Account Changes
$lang['update_successful'] = 'Compte utilisateur mise à jour avec succès';
$lang['update_unsuccessful'] = 'Impossible de mettre à jour le compte utilisateur';
$lang['delete_successful'] = 'Utilisateur supprimé';
$lang['delete_unsuccessful'] = 'Impossible de supprimer l\'utilisateur';

// Email Subjects
$lang['email_forgotten_password_subject']    = 'Mot de Passe Oublié - Vérification';
$lang['email_new_password_subject']          = 'Nouveau Mot de Passe';
$lang['email_activation_subject']            = 'Activation du compte';
