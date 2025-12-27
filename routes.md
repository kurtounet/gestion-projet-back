PS I:\gestion-projet\gestion-projet-symfony> php bin/console debug:router
 ------------------------------------------------------------------ ---------- ------------------------------------------------------- 
  Name                                                               Method     Path
                     
 ------------------------------------------------------------------ ---------- ------------------------------------------------------- 
  api_doc                                                            GET|HEAD   /api/docs.{_format}
  api_genid                                                          GET|HEAD   /api/.well-known/genid/{id}
  api_validation_errors                                              GET|HEAD   /api/validation_errors/{id}
  api_entrypoint                                                     GET|HEAD   /api/{index}.{_format}
  api_jsonld_context                                                 GET|HEAD   /api/contexts/{shortName}.{_format}
  _api_errors                                                        GET        /api/errors/{status}.{_format}
  _api_validation_errors_problem                                     GET        /api/validation_errors/{id}
  _api_validation_errors_hydra                                       GET        /api/validation_errors/{id}
  _api_validation_errors_jsonapi                                     GET        /api/validation_errors/{id}
  _api_validation_errors_xml                                         GET        /api/validation_errors/{id}s

  _api_/config_project_frameworks/{id}{._format}_get                 GET        /api/config_project_frameworks/{id}.{_format}
  _api_/config_project_frameworks{._format}_get_collection           GET        /api/config_project_frameworks.{_format}
  _api_/config_project_frameworks{._format}_post                     POST       /api/config_project_frameworks.{_format}
  _api_/config_project_frameworks/{id}{._format}_patch               PATCH      /api/config_project_frameworks/{id}.{_format}
  _api_/config_project_frameworks/{id}{._format}_delete              DELETE     /api/config_project_frameworks/{id}.{_format}
  
  _api_/frameworks/{id}{._format}_get                                GET        /api/frameworks/{id}.{_format}    
  _api_/frameworks{._format}_get_collection                          GET        /api/frameworks.{_format}
  _api_/frameworks{._format}_post                                    POST       /api/frameworks.{_format}
  _api_/frameworks/{id}{._format}_patch                              PATCH      /api/frameworks/{id}.{_format}
  _api_/frameworks/{id}{._format}_delete                             DELETE     /api/frameworks/{id}.{_format}    

  _api_/project_instances/{id}{._format}_get                         GET        /api/project_instances/{id}.{_format}
  _api_/project_instances{._format}_get_collection                   GET        /api/project_instances.{_format}
  _api_/project_instances{._format}_post                             POST       /api/project_instances.{_format}
  _api_/project_instances/{id}{._format}_patch                       PATCH      /api/project_instances/{id}.{_format}
  _api_/project_instances/{id}{._format}_delete                      DELETE     /api/project_instances/{id}.{_format}

  _api_/sprint_instances/{id}{._format}_get                          GET        /api/sprint_instances/{id}.{_format}
  _api_/sprint_instances{._format}_get_collection                    GET        /api/sprint_instances.{_format}
  _api_/sprint_instances{._format}_post                              POST       /api/sprint_instances.{_format}   
  _api_/sprint_instances/{id}{._format}_patch                        PATCH      /api/sprint_instances/{id}.{_format}
  _api_/sprint_instances/{id}{._format}_delete                       DELETE     /api/sprint_instances/{id}.{_format}

  _api_/task_instances/{id}{._format}_get                            GET        /api/task_instances/{id}.{_format}
  _api_/task_instances{._format}_get_collection                      GET        /api/task_instances.{_format} 
  _api_/task_instances{._format}_post                                POST       /api/task_instances.{_format}
  _api_/task_instances/{id}{._format}_patch                          PATCH      /api/task_instances/{id}.{_format}
  _api_/task_instances/{id}{._format}_delete                         DELETE     /api/task_instances/{id}.{_format}

  _api_/code_bases{._format}_get_collection                          GET        /api/code_bases.{_format}
  _api_/code_bases/{id}{._format}_get                                GET        /api/code_bases/{id}.{_format} 
  _api_/code_bases{._format}_post                                    POST       /api/code_bases.{_format}
  _api_/code_bases/{id}{._format}_patch                              PATCH      /api/code_bases/{id}.{_format}
  _api_/code_bases/{id}{._format}_delete                             DELETE     /api/code_bases/{id}.{_format}    

  _api_/comments{._format}_get_collection                            GET        /api/comments.{_format}
  _api_/comments/{id}{._format}_get                                  GET        /api/comments/{id}.{_format}      
  _api_/comments{._format}_post                                      POST       /api/comments.{_format}
  _api_/comments/{id}{._format}_patch                                PATCH      /api/comments/{id}.{_format}      
  _api_/comments/{id}{._format}_delete                               DELETE     /api/comments/{id}.{_format}      

  _api_/contexts{._format}_get_collection                            GET        /api/contexts.{_format}
  _api_/contexts/{id}{._format}_get                                  GET        /api/contexts/{id}.{_format}
  _api_/contexts{._format}_post                                      POST       /api/contexts.{_format}
  _api_/contexts/{id}{._format}_patch                                PATCH      /api/contexts/{id}.{_format}
  _api_/contexts/{id}{._format}_delete                               DELETE     /api/contexts/{id}.{_format}      

  _api_/context_statuses{._format}_get_collection                    GET        /api/context_statuses.{_format}
  _api_/context_statuses/{id}{._format}_get                          GET        /api/context_statuses/{id}.{_format}
  _api_/context_statuses{._format}_post                              POST       /api/context_statuses.{_format}
  _api_/context_statuses/{id}{._format}_patch                        PATCH      /api/context_statuses/{id}.{_format}
  _api_/context_statuses/{id}{._format}_delete                       DELETE     /api/context_statuses/{id}.{_format}

  _api_/features{._format}_get_collection                            GET        /api/features.{_format}
  _api_/features/{id}{._format}_get                                  GET        /api/features/{id}.{_format}
  _api_/features{._format}_post                                      POST       /api/features.{_format}
  _api_/features/{id}{._format}_patch                                PATCH      /api/features/{id}.{_format}
  _api_/features/{id}{._format}_delete                               DELETE     /api/features/{id}.{_format}      

  _api_/files{._format}_get_collection                               GET        /api/files.{_format}
  _api_/files/{id}{._format}_get                                     GET        /api/files/{id}.{_format}
  _api_/files{._format}_post                                         POST       /api/files.{_format}
  _api_/files/{id}{._format}_patch                                   PATCH      /api/files/{id}.{_format}
  _api_/files/{id}{._format}_delete                                  DELETE     /api/files/{id}.{_format}

  _api_/notifications{._format}_get_collection                       GET        /api/notifications.{_format}
  _api_/notifications/{id}{._format}_get                             GET        /api/notifications/{id}.{_format}
  _api_/notifications{._format}_post                                 POST       /api/notifications.{_format}
  _api_/notifications/{id}{._format}_patch                           PATCH      /api/notifications/{id}.{_format}
  _api_/notifications/{id}{._format}_delete                          DELETE     /api/notifications/{id}.{_format}

  _api_/priorities{._format}_get_collection                          GET        /api/priorities.{_format}
  _api_/priorities/{id}{._format}_get                                GET        /api/priorities/{id}.{_format}
  _api_/priorities{._format}_post                                    POST       /api/priorities.{_format}
  _api_/priorities/{id}{._format}_patch                              PATCH      /api/priorities/{id}.{_format}
  _api_/priorities/{id}{._format}_delete                             DELETE     /api/priorities/{id}.{_format}

  _api_/project_templates{._format}_get_collection                   GET        /api/project_templates.{_format}
  _api_/project_templates/{id}{._format}_get                         GET        /api/project_templates/{id}.{_format}
  _api_/project_templates{._format}_post                             POST       /api/project_templates.{_format}
  _api_/project_templates/{id}{._format}_patch                       PATCH      /api/project_templates/{id}.{_format}
  _api_/project_templates/{id}{._format}_delete                      DELETE     /api/project_templates/{id}.{_format}

  _api_/project_template_sprint_templates{._format}_get_collection   GET        /api/project_template_sprint_templates.{_format}
  _api_/project_template_sprint_templates/{id}{._format}_get         GET        /api/project_template_sprint_templates/{id}.{_format}
  _api_/project_template_sprint_templates{._format}_post             POST       /api/project_template_sprint_templates.{_format}
  _api_/project_template_sprint_templates/{id}{._format}_patch       PATCH      /api/project_template_sprint_templates/{id}.{_format}
  _api_/project_template_sprint_templates/{id}{._format}_delete      DELETE     /api/project_template_sprint_templates/{id}.{_format}

  _api_/sprint_tasks{._format}_get_collection                        GET        /api/sprint_tasks.{_format} 
  _api_/sprint_tasks/{id}{._format}_get                              GET        /api/sprint_tasks/{id}.{_format}  
  _api_/sprint_tasks{._format}_post                                  POST       /api/sprint_tasks.{_format}       
  _api_/sprint_tasks/{id}{._format}_patch                            PATCH      /api/sprint_tasks/{id}.{_format} 
  _api_/sprint_tasks/{id}{._format}_delete                           DELETE     /api/sprint_tasks/{id}.{_format}  

  _api_/sprint_templates{._format}_get_collection                    GET        /api/sprint_templates.{_format}
  _api_/sprint_templates/{id}{._format}_get                          GET        /api/sprint_templates/{id}.{_format}
  _api_/sprint_templates{._format}_post                              POST       /api/sprint_templates.{_format}
  _api_/sprint_templates/{id}{._format}_patch                        PATCH      /api/sprint_templates/{id}.{_format}
  _api_/sprint_templates/{id}{._format}_delete                       DELETE     /api/sprint_templates/{id}.{_format}

  _api_/statuses{._format}_get_collection                            GET        /api/statuses.{_format}
  _api_/statuses/{id}{._format}_get                                  GET        /api/statuses/{id}.{_format}
  _api_/statuses{._format}_post                                      POST       /api/statuses.{_format}
  _api_/statuses/{id}{._format}_patch                                PATCH      /api/statuses/{id}.{_format}
  _api_/statuses/{id}{._format}_delete                               DELETE     /api/statuses/{id}.{_format}      

  _api_/task_templates{._format}_get_collection                      GET        /api/task_templates.{_format}
  _api_/task_templates/{id}{._format}_get                            GET        /api/task_templates/{id}.{_format}
  _api_/task_templates{._format}_post                                POST       /api/task_templates.{_format}
  _api_/task_templates/{id}{._format}_patch                          PATCH      /api/task_templates/{id}.{_format}
  _api_/task_templates/{id}{._format}_delete                         DELETE     /api/task_templates/{id}.{_format}

  _api_/technologies{._format}_get_collection                        GET        /api/technologies.{_format}
  _api_/technologies/{id}{._format}_get                              GET        /api/technologies/{id}.{_format}
  _api_/technologies{._format}_post                                  POST       /api/technologies.{_format}
  _api_/technologies/{id}{._format}_patch                            PATCH      /api/technologies/{id}.{_format}
  _api_/technologies/{id}{._format}_delete                           DELETE     /api/technologies/{id}.{_format}  

  _api_/type_tasks{._format}_get_collection                          GET        /api/type_tasks.{_format}
  _api_/type_tasks/{id}{._format}_get                                GET        /api/type_tasks/{id}.{_format}
  _api_/type_tasks{._format}_post                                    POST       /api/type_tasks.{_format}
  _api_/type_tasks/{id}{._format}_patch                              PATCH      /api/type_tasks/{id}.{_format}
  _api_/type_tasks/{id}{._format}_delete                             DELETE     /api/type_tasks/{id}.{_format}    

  _api_/users{._format}_get_collection                               GET        /api/users.{_format}
  _api_/users/{id}{._format}_get                                     GET        /api/users/{id}.{_format}
  _api_/users{._format}_post                                         POST       /api/users.{_format}
  _api_/users/{id}{._format}_patch                                   PATCH      /api/users/{id}.{_format}
  _api_/users/{id}{._format}_delete                                  DELETE     /api/users/{id}.{_format}

  _preview_error                                                     ANY        /_error/{code}.{_format}
  _wdt_stylesheet                                                    ANY        /_wdt/styles
  _wdt                                                               ANY        /_wdt/{token}
  _profiler_home                                                     ANY        /_profiler/
  _profiler_search                                                   ANY        /_profiler/search
  _profiler_search_bar                                               ANY        /_profiler/search_bar
  _profiler_phpinfo                                                  ANY        /_profiler/phpinfo
  _profiler_xdebug                                                   ANY        /_profiler/xdebug
  _profiler_font                                                     ANY        /_profiler/font/{fontName}.woff2 
  _profiler_search_results                                           ANY        /_profiler/{token}/search/results 
  _profiler_open_file                                                ANY        /_profiler/open
  _profiler                                                          ANY        /_profiler/{token}
  _profiler_router                                                   ANY        /_profiler/{token}/router
  _profiler_exception                                                ANY        /_profiler/{token}/exception
  _profiler_exception_css                                            ANY        /_profiler/{token}/exception.css 

  app_home                                                           ANY        /home
  custom_project_instances_update_order                              PATCH      /custom/project_instances/order
  custom_sprint_instances_update_order                               PATCH      /custom/sprint_instances/order
  custom_task_instances_update_order                                 PATCH      /custom/task_instances/order
  api_login_check                                                    ANY        /api/login_check

 ------------------------------------------------------------------ ---------- -------------------------------------------------------

PS I:\gestion-projet\gestion-projet-symfony>
