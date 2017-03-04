<?php
declare(strict_types=1);

namespace Command;

/**
 * A CLI Command
 */
class Command
{
    /** @var string Command name */
    private $name;

    /** @var string Command to execute */
    private $command;

    /** @var array Command Options */
    private $options;

    /** @var array Arguments */
    private $arguments;

    /**
     * Construct a CLI Command
     *
     * @param string $name      Command name
     * @param string $command   Command to execute
     * @param array  $options   Command Options
     * @param array  $arguments Command Arguments
     */
    public function __construct(string $name, string $command, array $options = [], array $arguments = [])
    {
        $this->name = $name;
        $this->command = $command;
        $this->options = $options;
        $this->arguments = $arguments;
    }

    /**
     * Build the command to be executed
     *
     * @return string
     */
    private function build()
    {
        $command = $this->command;

        foreach ($this->arguments as $argument) {
            $command .= " $argument";
        }

        foreach ($this->options as $option => $value) {
            $command .= " --$option";
            if (!is_null($value)) {
                $command .= " $value";
            }
        }

        return $command;
    }

    /**
     * Execute the command
     *
     * @return bool
     */
    public function execute()
    {
        $name = $this->name;
        echo "Running {$name}...\n";
        exec($this->build(), $checkOutput, $result);

        if ($result !== 0) {
            // Convert check out into readable summary format
            $output = array_pop($checkOutput);
            $output = array_pop($checkOutput) . "\n{$output}\n";
            echo "{$output}Did you break something?\nAborting\n";
            return false;
        }
        echo "{$name} Passed!\n";
        return true;
    }
}
