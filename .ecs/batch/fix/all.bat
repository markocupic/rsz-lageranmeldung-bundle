:: Run easy-coding-standard (ecs) via this batch file inside your IDE e.g. PhpStorm (Windows only)
:: Install inside PhpStorm the  "Batch Script Support" plugin
cd..
cd..
cd..
cd..
cd..
cd..
:: src
vendor\bin\ecs check vendor/markocupic/rsz-lageranmeldung-bundle/src --fix --config vendor/markocupic/rsz-lageranmeldung-bundle/.ecs/config/default.yaml
:: tests
vendor\bin\ecs check vendor/markocupic/rsz-lageranmeldung-bundle/tests --fix --config vendor/markocupic/rsz-lageranmeldung-bundle/.ecs/config/default.yaml
:: legacy
vendor\bin\ecs check vendor/markocupic/rsz-lageranmeldung-bundle/src/Resources/contao --fix --config vendor/markocupic/rsz-lageranmeldung-bundle/.ecs/config/legacy.yaml
:: templates
vendor\bin\ecs check vendor/markocupic/rsz-lageranmeldung-bundle/src/Resources/contao/templates --fix --config vendor/markocupic/rsz-lageranmeldung-bundle/.ecs/config/template.yaml
::
cd vendor/markocupic/rsz-lageranmeldung-bundle/.ecs./batch/fix
