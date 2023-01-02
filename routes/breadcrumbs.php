<?php

use App\Models\AccessRequest;
use App\Models\Account;
use App\Models\Checklist;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSection;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('checklist', function (BreadcrumbTrail $trail) {
    $trail->push('Checklists');
});

Breadcrumbs::for('checklist.list', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');

    $trail->parent('checklist');

    $trail->push('List', route('checklist.list'));
});

Breadcrumbs::for('checklist.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('checklist.list');

    $trail->push('Create', route('checklist.create'));
});

Breadcrumbs::for('checklist.edit', function (BreadcrumbTrail $trail, Checklist $checklist): void {
    $trail->parent('checklist.list');

    $trail->push('Edit', route('checklist.edit', $checklist));
});


Breadcrumbs::for('checklist.overview', function (BreadcrumbTrail $trail): void {
    $trail->parent('home');

    $trail->parent('checklist');

    $trail->push('Services Checklist', route('checklist.overview'));
});

Breadcrumbs::for('checklist.overviewForChecklist', function (BreadcrumbTrail $trail, Checklist $checklist): void {
    $trail->parent('checklist.overview');

    $trail->push('Details', route('checklist.overviewForChecklist', $checklist));
});

Breadcrumbs::for('checklist.checklistForAccount', function (BreadcrumbTrail $trail, Account $account) {
    $trail->parent('checklist.list');

    $trail->push('Account', route('checklist.checklistForAccount', $account));
});

// Admin
Breadcrumbs::for('admin', function (BreadcrumbTrail $trail) {
    $trail->parent('home');

    $trail->push('Admin');
});

// Admin Accounts
Breadcrumbs::for('admin.account.list', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');

    $trail->push('Accounts');

    $trail->push('List', route('admin.account.list'));
});

Breadcrumbs::for('admin.account.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.account.list');

    $trail->push('Create', route('admin.account.create'));
});

Breadcrumbs::for('admin.account.edit', function (BreadcrumbTrail $trail, Account $account) {
    $trail->parent('admin.account.list');

    $trail->push('Edit', route('admin.account.edit', $account));
});

// Admin Checklists
Breadcrumbs::for('admin.checklist.list', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');

    $trail->push('Checklists');

    $trail->push('List', route('admin.checklist.list'));
});

Breadcrumbs::for('admin.checklist.create', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin.checklist.list');

    $trail->push('Create', route('admin.checklist.create'));
});

Breadcrumbs::for('admin.checklist.edit', function (BreadcrumbTrail $trail, Checklist $checklist): void {
    $trail->parent('admin.checklist.list');

    $trail->push('Edit', route('admin.checklist.edit', $checklist));
});

Breadcrumbs::for('admin.checklist.overview', function (BreadcrumbTrail $trail): void {
    $trail->parent('admin');

    $trail->push('Checklists');

    $trail->push('Services Checklist', route('admin.checklist.overview'));
});

Breadcrumbs::for('admin.checklist.overviewForChecklist', function (BreadcrumbTrail $trail, Checklist $checklist): void {
    $trail->parent('admin.checklist.overview');

    $trail->push('Details', route('admin.checklist.overviewForChecklist', $checklist));
});

// Admin Categories
Breadcrumbs::for('admin.category.list', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');

    $trail->push('Services Categories');

    $trail->push('List', route('admin.category.list'));
});

Breadcrumbs::for('admin.category.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.category.list');

    $trail->push('Create', route('admin.category.create'));
});

Breadcrumbs::for('admin.category.edit', function (BreadcrumbTrail $trail, ServiceCategory $category) {
    $trail->parent('admin.category.list');

    $trail->push('Edit', route('admin.category.edit', $category));
});

// Admin Sections
Breadcrumbs::for('admin.section.list', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');

    $trail->push('Services Section');

    $trail->push('List', route('admin.section.list'));
});

Breadcrumbs::for('admin.section.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.section.list');

    $trail->push('Create', route('admin.section.create'));
});

Breadcrumbs::for('admin.section.edit', function (BreadcrumbTrail $trail, ServiceSection $section) {
    $trail->parent('admin.section.list');

    $trail->push('Edit', route('admin.section.edit', $section));
});

// Admin Services
Breadcrumbs::for('admin.service.list', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');

    $trail->push('Services');

    $trail->push('List', route('admin.service.list'));
});

Breadcrumbs::for('admin.service.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.service.list');

    $trail->push('Create', route('admin.service.create'));
});

Breadcrumbs::for('admin.service.edit', function (BreadcrumbTrail $trail, Service $service) {
    $trail->parent('admin.service.list');

    $trail->push('Edit', route('admin.service.edit', $service));
});

// Admin Access
Breadcrumbs::for('admin.access.pending', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');

    $trail->push('Access Control');

    $trail->push('Manage Requests', route('admin.access.pending'));
});

Breadcrumbs::for('admin.access.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.access.pending');

    $trail->push('Grant', route('admin.access.create'));
});

Breadcrumbs::for('admin.access.edit', function (BreadcrumbTrail $trail, AccessRequest $access) {
    $trail->parent('admin.access.pending');

    $trail->push('Edit', route('admin.access.edit', $access));
});

Breadcrumbs::for('admin.access.users', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');

    $trail->push('Access Control');

    $trail->push('Users in BlueGroup', route('admin.access.users'));
});

Breadcrumbs::for('admin.access.admins', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');

    $trail->push('Access Control');

    $trail->push('Administrators in BlueGroup', route('admin.access.admins'));
});

Breadcrumbs::for('login', function (BreadcrumbTrail $trail) {
    $trail->parent('home');

    $trail->push('Log on', route('login'));
});

Breadcrumbs::for('logout', function (BreadcrumbTrail $trail) {
    $trail->parent('home');

    $trail->push('Log out', route('logout'));
});
