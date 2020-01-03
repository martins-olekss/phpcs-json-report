# PHP Code Sniffer Report Creator
Combines PHPCS, Symfony Process to retrieve results from PHP Code Sniffer, group by issues and present in readable HTML format

## Usage
1) Update settings in `process.php` ( phpcs location, standards to scan, directory to scan)
2) Run ```process.php``` from console
3) Confirm new report file is created in `pub/report`
4) View report file

## Directories
- ```tmp``` directory holds temporary json file before processing and storing in database
- ```pub/report``` directory holds html report files
- ```process.php``` - starts standard scan, when completed starts separate process (`out.php`) that creates html report file
- ```out.php``` - holds code for html report creation

## Example of command
`phpcs --standard=Zend -s --extensions=php,phtml --report=json --report-file=report.json path/to/code`
- pass parameter `-s` to include source field in report ( sniff ID )
- Zend standard used only as example

Depending on method of Code Sniffer installation, you might need to replace `php phpcs.phar` with `phpcs`
