1. Generate JSON report with PHP Code Sniffer ( enable '-s' parameter )
2. Configure BASE path and execute PHP script, pipe to output HTML file

# Example of command
`php phpcs.phar --standard=Zend -s --report=json --report-file=report.json path/to/code`
- pass parameter `-s` to include source field in report ( sniff ID )
