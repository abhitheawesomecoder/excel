<?php

return [

    'settings' => ['module' => 'Settings',

                   'menu' => [ 'security' => [ 'label' => 'Security', 'form' => ['title' => 'Change Password', 'subtitle' => 'Set New Password']],
                               'company' => [ 'label' => 'Company', 'form' => ['title' => 'Company Settings', 'subtitle' => 'Set Company Details']],
                               'account' => [ 'label' => 'Account', 'form' => ['title' => 'Account Settings', 'subtitle' => 'Set Account Details']]
                              ]

                  ],

    'dashboard' => ['module' => 'Dashboard',
                    'widgets' => [  
                                    'upcomingjobs' => 'UPCOMING JOBS',
                                    'completedjobs' => 'JOBS COMPLETED',
                                    'upcomingtasks' => 'UPCOMING TASKS',
                                    'completedtasks' => 'TASKS COMPLETED',
                                    'calendar' => 'UPCOMING & COMPLETED JOBS'
                                ]
                   ],

    'contractor_navigation' => 'NAVIGATION',

    'main_navigation' => 'MAIN NAVIGATION',

    'jobtype' => [
        'create' => ['title' => 'Job Type', 
                     'subtitle' => 'Add Job Type'
         ],
         'update' => ['title' => 'Job Type', 
                     'subtitle' => 'Update Job Type'
         ],
         'view' => ['title' => 'Job Type', 
                     'subtitle' => 'View Job Type'
         ]
    ],

    'job' => [
        'requested' => ['title' => 'Job', 
                     'subtitle' => 'Job Requested'
         ],
         'confirmed' => ['title' => 'Job', 
                     'subtitle' => 'Job Confirmed'
         ],
         'completed' => ['title' => 'Job', 
                     'subtitle' => 'Job Completed'
         ]
    ],

	'storecontact' => [
        'create' => ['title' => 'Store Contact', 
                     'subtitle' => 'Add Store Contact'
         ],
         'update' => ['title' => 'Store Contact', 
                     'subtitle' => 'Update Store Contact'
         ],
         'view' => ['title' => 'Store Contact', 
                     'subtitle' => 'View Store Contact'
         ]
    ],
    'user' => [
        'create' => ['title' => 'User', 
                     'subtitle' => 'Add User'
         ],
         'update' => ['title' => 'User', 
                     'subtitle' => 'Update User'
         ],
         'view' => ['title' => 'User', 
                     'subtitle' => 'View User'
         ]
    ],
    'signups' => [
        'create' => ['title' => 'Signup', 
                     'subtitle' => 'Add Signup'
         ],
         'signin' => ['title' => 'Signin', 
                     'subtitle' => 'User Signin'
         ],
         'update' => ['title' => 'Signup', 
                     'subtitle' => 'Update Signup'
         ],
         'view' => ['title' => 'Signup', 
                     'subtitle' => 'View Signup'
         ]
    ],
    'store' => [
        'create' => ['title' => 'Store', 
                     'subtitle' => 'Add Store'
         ],
         'update' => ['title' => 'Store', 
                     'subtitle' => 'Update Store'
         ],
         'view' => ['title' => 'Store', 
                     'subtitle' => 'View Store'
         ]
    ],
    'client' => [
        'create' => ['title' => 'Client', 
                     'subtitle' => 'Add Client'
         ],
         'update' => ['title' => 'Client', 
                     'subtitle' => 'Update Client'
         ],
         'view' => ['title' => 'Client', 
                     'subtitle' => 'View Client'
         ]
    ],
    'clientcontact' => [
        'create' => ['title' => 'Client Contact', 
                     'subtitle' => 'Add Client Contact'
         ],
         'update' => ['title' => 'Client Contact', 
                     'subtitle' => 'Update Client Contact'
         ],
         'view' => ['title' => 'Client Contact', 
                     'subtitle' => 'View Client Contact'
         ]
    ],
    'contact' => [
        'create' => ['title' => 'Contact', 
                     'subtitle' => 'Add Contact'
         ],
         'update' => ['title' => 'Contact', 
                     'subtitle' => 'Update Contact'
         ],
         'view' => ['title' => 'Contact', 
                     'subtitle' => 'View Contact'
         ]
    ],
    'contractor' => [
        'create' => ['title' => 'Contractor', 
                     'subtitle' => 'Add Contractor'
         ],
         'update' => ['title' => 'Contractor', 
                     'subtitle' => 'Update Contractor'
         ],
         'view' => ['title' => 'Contractor', 
                     'subtitle' => 'View Contractor'
         ],
         'edit' => ['title' => 'Contractor', 
                     'subtitle' => 'Edit Contractor'
         ]
    ],
    'contractorsignup' => [
        'create' => ['title' => 'Contractor Signup', 
                     'subtitle' => 'Send signup request to Contractor'
         ],
         'update' => ['title' => 'Contractor', 
                     'subtitle' => 'Update Contractor'
         ],
         'view' => ['title' => 'Contractor', 
                     'subtitle' => 'View Contractor'
         ]
    ],
    'jobs' => [
        'create' => ['title' => 'Jobs', 
                     'subtitle' => 'Add Job'
         ],
         'update' => ['title' => 'Jobs', 
                     'subtitle' => 'Update Job'
         ],
         'view' => ['title' => 'Jobs', 
                     'subtitle' => 'View Job'
         ],
         'edit' => ['title' => 'Jobs', 
                     'subtitle' => 'Edit Job'
         ]
    ],

];