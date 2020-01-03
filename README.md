# PHP Code Sniffer Report Creator
Combines PHPCS, Symfony Process to retrieve results from PHP Code Sniffer, group by issues and present in readable HTML format

##
```tmp``` directory holds temporary json file before processing and storing in database

# Usage ( planned )
1. Generate JSON report with PHP Code Sniffer ( enable '-s' parameter )
2. Configure BASE path and execute PHP script, pipe to output HTML file

## Example of command
`phpcs --standard=Zend -s --extensions=php,phtml --report=json --report-file=report.json path/to/code`
- pass parameter `-s` to include source field in report ( sniff ID )
- Zend standard used as example

Depending on method of Code Sniffer installation, you might need to replace `php phpcs.phar` with `phpcs`

## Future plans
- Improve final output
- Probably add templating engine ( like Twig ) for better experience of creating new output designs
