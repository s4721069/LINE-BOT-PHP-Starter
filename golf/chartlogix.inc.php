<?php

/**
 * ChartLogix v1.06
 *
 * PHP Charting Library for Bar Charts, Line Graphs, Pie Charts
 * High-quality anti-aliased graphics rendered by PHP using GD.
 *
 * Generate your PHP source code using the chart designed:
 *
 *   http://www.phpcharting.com/designer/
 *
 * Full documentation and examples are in the Documentation directory in this package.
 */

 
/**
 * BarChart - ChartLogix Bar Chart class - self contained bar chart renderer using GD
  *
 * @example There is an overview at            Documentation/bar_graph.html
 * @example Function reference at              Documentation/bar_graph-function_reference.html
 * @example Lots of examples with source code  Documentation/bar_graph-examples.html
*/
class BarChart
{


    //---- DATA

    //  Background colours for gradient

    /**
     * @var int
     */
    private $bg1 = 0xEEEEEE;
    /**
     * @var int
     */
    private $bg2 = 0xEEEEEE;

    /**
     * @var int
     */
    private $padding = 20;


    //  Settings

    /**
     * @var string
     */
    private $default_font = 'arial.ttf';

    /**
     * @var string
     */
    private $title_font = '';
    /**
     * @var int
     */
    private $title_font_size = 15;
    /**
     * @var int
     */
    private $title_col = 0x000000;

    /**
     * @var int
     */
    private $legend_width = 40;

    /**
     * @var string
     */
    private $legend_font = '';
    /**
     * @var int
     */
    private $legend_font_size = 10;
    /**
     * @var int
     */
    private $legend_font_col = 0x000000;

    /**
     * @var int
     */
    private $legend_between_padding = 10;

    /**
     * @var int
     */
    private $legend_bg = 0xFFFFFF;
    /**
     * @var int
     */
    private $legend_border = 0x000000;
    /**
     * @var int
     */
    private $legend_box_padding = 10;

    /**
     * @var int
     */
    private $legend_key_size = 10;
    /**
     * @var int
     */
    private $legend_key_padding = 10;

    /**
     * @var int
     */
    private $legend_xpos = 1;
    /**
     * @var int
     */
    private $legend_ypos = 0;

    /**
     * @var int
     */
    private $title_xpos = 0;
    /**
     * @var int
     */
    private $title_ypos = 0;

    /**
     * @var string
     */
    private $xaxis_font = '';
    /**
     * @var int
     */
    private $xaxis_font_size = 10;
    /**
     * @var int
     */
    private $xaxis_font_col = 0x000000;
    /**
     * @var int
     */
    private $xaxis_font_angle = 0;

    /**
     * @var string
     */
    private $yaxis_font = '';
    /**
     * @var int
     */
    private $yaxis_font_size = 10;
    /**
     * @var int
     */
    private $yaxis_font_col = 0x000000;

    /**
     * @var int
     */
    private $column_spacing = 25;
    /**
     * @var int
     */
    private $bar_spacing = 0;

    /**
     * @var int
     */
    private $line_thickness = 4;
    /**
     * @var int
     */
    private $line_dot_size = 7;

    /**
     * @var bool|float
     */
    private $yaxis_max = false; //  false = use default
    /**
     * @var bool|float
     */
    private $yaxis_min = false; //  false = use default

    /**
     * The font to use when displaying values against bars in the graph
     * @var bool|string false = no font (no values shown), '' = default font, or a font name
     */
    private $value_font = false;
    /**
     * @var int
     */
    private $value_size = 8;
    /**
     * @var int
     */
    private $value_col = 0x000000;
    /**
     * @var int
     */
    private $value_pos = 1;
    /**
     * @var int
     */
    private $value_angle = 0;

    /**
     * @var array
     */
    private $axis_data = array();

    /**
     * @var string
     */
    private $xaxis_title_font = '';
    /**
     * @var int
     */
    private $xaxis_title_font_size = 12;
    /**
     * @var int
     */
    private $xaxis_title_font_col = 0x000000;

    /**
     * @var string
     */
    private $yaxis_title_font = '';
    /**
     * @var int
     */
    private $yaxis_title_font_size = 12;
    /**
     * @var int
     */
    private $yaxis_title_font_col = 0x000000;


    //  The bar data

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var array
     */
    private $data = array();
    /**
     * @var int
     */
    private $series = 0;
    /**
     * @var bool
     */
    private $using_series = false;

    /**
     * @var array
     */
    private $columns = array();
    /**
     * @var array
     */
    private $columns_list = array();



    //---- Constructor

    function __construct()
    {
        $this->data[$this->series] = array();

        $this->data[$this->series]['type'] = 'bar';

        $this->data[$this->series]['name'] = '';
        $this->data[$this->series]['col1'] = $this->hexcol(0xFFFFFF);
        $this->data[$this->series]['col2'] = $this->hexcol(0xFFFFFF);
        $this->data[$this->series]['in_legend'] = true;
        $this->data[$this->series]['data'] = array();

        $this->data[$this->series]['value_font'] = $this->value_font;
        $this->data[$this->series]['value_size'] = $this->value_size;
        $this->data[$this->series]['value_col'] = $this->value_col;
        $this->data[$this->series]['value_pos'] = $this->value_pos;
        $this->data[$this->series]['value_angle'] = $this->value_angle;

        $this->axis_data = array
        (
            array('a' => 'y',
                'd' => 1,
                't' => ''),
            array('a' => 'x',
                'd' => 1,
                't' => ''),
            array('a' => '',
                'd' => 0,
                't' => ''),
            array('a' => '',
                'd' => 0,
                't' => '')
        );
    }


    //---- STYLE FUNCTIONS

    /**
     * setDefaultFont - Sets the default font which will be used for the title, legend and any other text,
     * if you do not explicitly specify fonts for them. ChartLogix will look in the same directory as chartlogix.inc.php
     * if you specify a font name without a path.
     *
     * @param string $font Font to use as the default
     */
    function setDefaultFont($font)
    {
        $this->default_font = $font;
    }

    /**
     * setBackground - Sets the background colour of the image, allowing you to create a vertical gradient by specifying a top and bottom colour.
     * Colours are specified as hexadecimal HTML colours, either as a string or an integer
     *
     * @example $chart->setBackground( '99CCFF' );  //  Sets the background to light blue.
     * @example $chart->setBackground( 0x99CCFF );  //  Sets the background to light blue using an integer hexadecimal number.
     * @example $chart->setBackground( 'DDDDDD', '999999' );  //  Sets the background to a gradient from light grey to slightly darker grey.
     *
     * @param string|int $c1 Colour of background at the top of the image
     * @param string|int $c2 Colour of background at the bottom of the image. If not specified, the background is the solid colour specified by $c1.
     */
    function setBackground($c1 = 0xEEEEEE, $c2 = false)
    {
        if ($c2 === false) {
            $c2 = $c1;
        }
        $this->bg1 = $this->hexcol($c1);
        $this->bg2 = $this->hexcol($c2);
    }

    /**
     * setPadding - Controls the spacing between the elements of the image - the chart, the title and the legend, and also the distance between these elements and the edge of the image.
     * @param int $padding (Default 20) Size of the padding in pixels.
     */
    function setPadding($padding = 20)
    {
        $padding = intval($padding);
        if ($padding < 0) {
            $padding = 0;
        }
        $this->padding = $padding;
    }

    /**
     * setTitleStyle - Sets the font, size and colour of the title of the graph
     *
     * @example $chart->setTitleStyle( "Verdana", 20, '000066' );  //  Sets the title style to Verdana, size 20, dark blue.
     *
     * @param string $font (Optional; default Arial) Name of the font to use.
     * @param int $size (Optional; default 15) Size of the font in points
     * @param string|int $col Colour of the title, specified as a hexadecimal HTML colour.
     */
    function setTitleStyle($font = '', $size = 15, $col = 0x000000)
    {
        $size = intval($size);
        if ($size < 0) {
            $size = 0;
        }

        $this->title_font = $font;
        $this->title_font_size = $size;
        $this->title_col = $this->hexcol($col);
    }

    /**
     * setTitlePosition - Sets the position and alignment of the title
     *
     * @param int $xpos Horizontal alignment of the title, -1 = Left aligned, 0 = Centred, 1 = Right aligned
     * @param int $ypos Vertical position, 0 = Top, 1 = Bottom
     */
    function setTitlePosition($xpos = 0, $ypos = 0)
    {
        $xpos = intval($xpos);
        $ypos = intval($ypos);

        $this->title_xpos = $xpos;
        $this->title_ypos = $ypos;
    }

    /**
     * setLegendWidth
     * Setting the legend width to 0 will hide the legend.
     *
     * @example $chart->setLegendWidth( 50 );  //  Sets the legend to be 50% of the width of the image.
     *
     * @param int $width Percentage of the width of the image taken up by the legend.
     */
    function setLegendWidth($width = 40)
    {
        $width *= 1.0;
        if ($width < 0) {
            $width = 0;
        }
        if ($width > 100) {
            $width = 100;
        }
        $this->legend_width = $width;
    }

    /**
     * setLegendTextStyle - Sets the style of the text in the legend.
     *
     * @example $chart->setLegendTextStyle( "Verdana", 8, '663300', 10 );
     *
     * @param string (Optional; default Arial) $font Font to use in the legend text.
     * @param int $size (Optional; default 10) Size of text in points.
     * @param int $col (Optional; default 000000) Colour of the text, specified as a hexadecimal HTML colour.
     * @param int $between (Optional; default 10) Spacing between items in the legend.
     */
    function setLegendTextStyle($font = '', $size = 10, $col = 0x000000, $between = 10)
    {
        $size = intval($size);
        $between = intval($between);

        $this->legend_font = $font;
        $this->legend_font_size = $size;
        $this->legend_font_col = $this->hexcol($col);

        $this->legend_between_padding = $between;
    }

    /**
     * setLegendBoxStyle - Sets the colours and the spacing for the legend box
     *
     * @example $chart->setLegendBoxStyle( 'FFFFCC', '333333', 20 );  //  Gives the legend box a light yellow background, dark grey border, and 20 pixels of padding.
     *
     * @param string|int $bg (Optional; default FFFFFF) The colour of the background of the legend
     * @param string|int $border (Optional; default 000000) The border colour of the legend
     * @param int $padding (Optional; default 10) The padding inside the legend box and between the legend items
     */
    function setLegendBoxStyle($bg = 0xFFFFFF, $border = 0x000000, $padding = 10)
    {
        $padding = intval($padding);

        $this->legend_bg = $this->hexcol($bg);
        $this->legend_border = $this->hexcol($border);
        $this->legend_box_padding = $padding;
    }

    /**
     * setLegendKeyStyle - Sets the style of the boxes next to the items in the legend.
     *
     * @param int $size (Optional; default 10) Size of the coloured squares.
     * @param int $padding (Optional; default 10) Horizontal distance between the coloured squares and the text next to them.
     */
    function setLegendKeyStyle($size = 10, $padding = 10)
    {
        $size = intval($size);
        $padding = intval($padding);

        $this->legend_key_size = $size;
        $this->legend_key_padding = $padding;
    }

    /**
     * setLegendPosition - Sets the position of the legend.
     *
     * @example $chart->setLegendPosition( 0, 0 );  //  Sets the legend to be in the top left corner of the image.
     *
     * @param int $xpos Horizontal position of legend: 0 = Left, 1 = Right
     * @param int $ypos Vertical alignment of the title: -1 = Top, 0 = Middle, 1 = Bottom
     */
    function setLegendPosition($xpos = 1, $ypos = 0)
    {
        $xpos = intval($xpos);
        $ypos = intval($ypos);

        $this->legend_xpos = $xpos;
        $this->legend_ypos = $ypos;
    }

    /**
     * setXAxisTextStyle - Sets the text style of the horizontal axis
     *
     * @param string $font Font to use for the labels
     * @param int $size (Optional; default 10) Size of the text in points
     * @param int $col (Optional; default 000000) Colour of the text
     * @param int $angle (Optional; default 0) Angle of the text, from 0 (horizontal) to 90 (vertical)
     */
    function setXAxisTextStyle($font = '', $size = 10, $col = 0x000000, $angle = 0)
    {
        $size = intval($size);
        $angle = intval($angle);

        if ($angle < -90) {
            $angle = 90;
        }
        if ($angle > 90) {
            $angle = 90;
        }

        $this->xaxis_font = $font;
        $this->xaxis_font_size = $size;
        $this->xaxis_font_col = $this->hexcol($col);
        $this->xaxis_font_angle = $angle;
    }

    /**
     * setYAxisTextStyle - Sets the text style of the vertical axis
     *
     * @param string $font Font to use for the labels
     * @param int $size (Optional; default 10) Size of the text in points
     * @param int $col (Optional; default 000000) Colour of the text
     */
    function setYAxisTextStyle($font = '', $size = 10, $col = 0x000000)
    {
        $size = intval($size);

        $this->yaxis_font = $font;
        $this->yaxis_font_size = $size;
        $this->yaxis_font_col = $this->hexcol($col);
    }

    /**
     * setYAxisMaximum - Sets the maximum value of the Y-axis.
     * By default the Y-axis scales automatically with the data but this function lets you override the default behaviour.
     *
     * @param number|bool $max Maximum value for the Y-Axis, or false to use the automatic default.
     */
    function setYAxisMaximum($max = false)
    {
        if ($max !== false) {
            $max = 1.0 * $max;
        }
        $this->yaxis_max = $max;
    }

    /**
     * setYAxisMinimum - Sets the minimum value of the Y-axis.
     * By default the Y-axis automatically starts at 0 unless there are any data values which are negative.
     *
     * @param number|bool $min Minimum value for the Y-Axis, or false to use the automatic default.
     */
    function setYAxisMinimum($min = false)
    {
        if ($min !== false) {
            $min = 1.0 * $min;
        }
        $this->yaxis_min = $min;
    }

    /**
     * setColumnSpacing - Sets the spacing either side of the bars within each column of the graph.
     *
     * @example $chart->setColumnSpacing( 100 );  //  Sets the spacing either side of the bar to be the same width as the bar itself, so the bar takes up one third of the total width of each column.
     * @example $chart->setColumnSpacing( 50 );  //  Sets the spacing either side of the bar to be the half the width as the bar itself, so the bar takes up one half of the total width of each column.
     *
     * @param int $spacing (Optional; default 25) Spacing, specified as a percentage of the width of the bars.
     */
    function setColumnSpacing($spacing = 25)
    {
        $spacing = intval($spacing);

        $this->column_spacing = $spacing;
    }

    /**
     * setStackedBarSpacing - Sets the spacing between bars when there are multiple stacks.
     *
     * @param int $spacing (Optional; default 0) Spacing, specified as a percentage of the width of the bars.
     */
    function setStackedBarSpacing($spacing = 0)
    {
        $spacing = intval($spacing);
        if ($spacing < -100) {
            $spacing = -100; //  No more than 100% overlap
        }

        $this->bar_spacing = $spacing;
    }

    /**
     * setStackedBarOverlap - Sets the overlap of the bars when there are multiple stacks.
     *
     * @param int $overlap (Optional; default 0) Overlap, specified as a percentage of the width of the bars. 0 is no overlap, 100 is complete overlap.
     */
    function setStackedBarOverlap($overlap = 0)
    {
        $overlap = intval($overlap);
        if ($overlap > 100) {
            $overlap = 100; //  No more than 100% overlap
        }

        $this->bar_spacing = -$overlap;
    }

    /**
     * setValueStyle - Allows labels to be added to the bars showing their values -
     * these labels can be placed above the bar or inside the bar, and the text can be horizontal or vertical.
     * Each series can have it's own value style settings, or the same settings can be used for all.
     *
     * @param string $font Font to use for the labels
     * @param int $size (Optional; default 10) Size of the font
     * @param string|int $col (Optional; default 000000) Colour of the text labels
     * @param int $pos (Optional; default 1) Position of the text labels: 1 = Above bars, 2 = Inside bars, at the top, 3 = Inside bars, centred, 4 = Inside bars, at the bottom
     * @param int $angle (Optional; default 0) The angle of the text - from 0 (horizontal), up to 90 (vertical)
     */
    function setValueStyle($font = false, $size = 8, $col = 0x000000, $pos = 1, $angle = 0)
    {
        $size = intval($size);
        if ($size < 0) {
            $size = 0;
        }
        $pos = intval($pos);
        $angle = intval($angle);
        if ($angle < -90) {
            $angle = -90;
        }
        if ($angle > 90) {
            $angle = 90;
        }

        $this->data[$this->series]['value_font'] = $font;
        $this->data[$this->series]['value_size'] = $size;
        $this->data[$this->series]['value_col'] = $this->hexcol($col);
        $this->data[$this->series]['value_pos'] = $pos;
        $this->data[$this->series]['value_angle'] = $angle;

        $this->value_font = $font;
        $this->value_size = $size;
        $this->value_col = $this->hexcol($col);
        $this->value_pos = $pos;
        $this->value_angle = $angle;
    }

    /**
     * setXAxisTitleStyle - Sets the style of the title shown on the X Axis
     *
     * @param string $font Filename of the TTF font file to use for the title
     * @param int $size (Optional; default 10) Size of the font
     * @param string|int $col (Optional; default 000000) Colour of the text labels
     */
    function setXAxisTitleStyle($font = '', $size = 12, $col = '000000')
    {
        $this->xaxis_title_font = $font;
        $this->xaxis_title_font_size = intval($size);
        $this->xaxis_title_font_col = $this->hexcol($col);
    }

    /**
     * setYAxisTitleStyle - Sets the style of the title shown on the Y Axis
     *
     * @param string $font Filename of the TTF font file to use for the title
     * @param int $size (Optional; default 10) Size of the font
     * @param string|int $col (Optional; default 000000) Colour of the text labels
     */
    function setYAxisTitleStyle($font = '', $size = 12, $col = '000000')
    {
        $this->yaxis_title_font = $font;
        $this->yaxis_title_font_size = intval($size);
        $this->yaxis_title_font_col = $this->hexcol($col);
    }

    /**
     * clearAxes - Removes the default axes, ready for you to place the axes around the edge of the graph manually using the
     * setLeftAxis, setRightAxis, setTopAxis and setBottomAxis functions.
     */
    function clearAxes()
    {
        $this->axis_data = array
        (
            array('a' => '',
                'd' => 1,
                't' => ''),
            array('a' => '',
                'd' => 1,
                't' => ''),
            array('a' => '',
                'd' => 1,
                't' => ''),
            array('a' => '',
                'd' => 1,
                't' => '')
        );
    }

    /**
     * Internal function to set up an axis record
     *
     * @param int $axis_index
     * @param string $axis
     * @param string $dir
     * @param string $text
     *
     * @return bool Whether the desired axis is compatible with the existing axes
     */
    private function setAxis($axis_index, $axis, $dir = '', $text = '')
    {
        $opposite = ($axis_index + 2) % 4;
        $left = ($axis_index + 1) % 4;
        $right = ($axis_index + 3) % 4;

        $axis = $axis == 'x' ? 'x' : ($axis == 'y' ? 'y' : '');
        $dir = $dir == 'left' || $dir == 'down' || $dir == -1 ? -1 : 1;

        //  Make sure this axis is not on one of the adjacent sides

        if ($this->axis_data[$left]['a'] == $axis) {
            return false;
        }
        if ($this->axis_data[$right]['a'] == $axis) {
            return false;
        }

        //  Make sure the opposite side does not have the other axis

        if ($this->axis_data[$opposite]['a'] != $axis && $this->axis_data[$opposite]['a'] != '') {
            return false;
        }

        //  Make sure the opposite side does not have this axis but the other way up

        if ($this->axis_data[$opposite]['a'] == $axis && $this->axis_data[$opposite]['d'] != $dir) {
            return false;
        }

        $this->axis_data[$axis_index] = array('a' => $axis,
            'd' => $dir,
            't' => $text);

        return true;
    }

    /**
     * setLeftAxis - Sets the axis to appear on the left hand edge of the graph (by default this is the Y Axis, running up).
     *
     * @param $axis Axis to display along the left hand edge of the graph: 'x' = X Axis, 'y' = Y Axis
     * @return bool Returns true if this axis fits with the previously added axes, false if there is a conflict
     */
    function setLeftAxis($axis)
    {
        return $this->setAxis(0, $axis);
    }

    /**
     * setRightAxis - Sets the axis to appear on the right hand edge of the graph (by default no axis is displayed there).
     *
     * @param $axis Axis to display along the right hand edge of the graph: 'x' = X Axis, 'y' = Y Axis
     * @return bool Returns true if this axis fits with the previously added axes, false if there is a conflict
     */
    function setRightAxis($axis)
    {
        return $this->setAxis(2, $axis);
    }

    /**
     * setTopAxis - Sets the axis to appear on the top edge of the graph (by default no axis is displayed there).
     * @param $axis Axis to display along the top edge of the graph: 'x' = X Axis, 'y' = Y Axis
     * @return bool Returns true if this axis fits with the previously added axes, false if there is a conflict
     */
    function setTopAxis($axis)
    {
        return $this->setAxis(3, $axis);
    }

    /**
     * setBottomAxis - Sets the axis to appear on the bottom edge of the graph (by default this is the X Axis, running right).
     * @param $axis Axis to display along the bottom edge of the graph: 'x' = X Axis, 'y' = Y Axis
     * @return bool Returns true if this axis fits with the previously added axes, false if there is a conflict
     */
    function setBottomAxis($axis)
    {
        return $this->setAxis(1, $axis);
    }

    /**
     * setLeftAxisTitle - Sets the axis title to appear on the left hand edge of the graph
     * @param string $text Title for this axis
     */
    function setLeftAxisTitle($text = '')
    {
        $this->axis_data[0]['t'] = $text;
    }

    /**
     * setRightAxisTitle - Sets the axis title to appear on the right hand edge of the graph
     * @param string $text Title for this axis
     */
    function setRightAxisTitle($text = '')
    {
        $this->axis_data[2]['t'] = $text;
    }

    /**
     * setTopAxisTitle - Sets the axis title to appear on the top edge of the graph
     * @param string $text Title for this axis
     */
    function setTopAxisTitle($text = '')
    {
        $this->axis_data[3]['t'] = $text;
    }

    /**
     * setBottomAxisTitle - Sets the axis title to appear on the bottom edge of the graph
     * @param string $text Title for this axis
     */
    function setBottomAxisTitle($text = '')
    {
        $this->axis_data[1]['t'] = $text;
    }

    /**
     * setGraphOrientation
     * @param int $orientation 0 = Vertical graph (default), 1 = Horizontal graph
     */
    function setGraphOrientation($orientation = 0)
    {
        if ($orientation == 0) {
            $this->clearAxes();
            $this->setLeftAxis('y');
            $this->setBottomAxis('x');
        }
        else {
            $this->clearAxes();
            $this->setLeftAxis('x');
            $this->setBottomAxis('y');
        }
    }


    //---- DATA FUNCTIONS

    /**
     * setTitle - Sets the title to display in the image.
     * @param string $title The title to display. If it is too long for one line it will be split onto multiple lines.
     */
    function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * addColumns - Adds a set of columns to the graph.
     * This can be used in combination with addColumn() in any order, both of these functions just add the columns onto the end of the current list of columns.
     *
     * @example $chart->addColumns( array( 2001, 2002, 2003, 2004, 2005, 2006 ) );
     *
     * @param array[string] $columns PHP array of column names, as they will appear along the X axis.
     */
    function addColumns($columns)
    {
        if (is_array($columns)) {
            foreach ($columns as $column) {
                if (!isset($this->columns_list[$column])) {
                    $this->columns[] = $column;
                    $this->columns_list[$column] = 1;
                }
            }
        }
        else {
            if (!isset($this->columns_list[$columns])) {
                $this->columns[] = $columns;
                $this->columns_list[$columns] = 1;
            }
        }
    }

    /**
     * addColumn - Adds a column to the graph.
     * This can be used in combination with addColumns, both of these functions just add the columns onto the end of the current list of columns.
     * @param string $column The name of the column, as it will appear along the X axis.
     */
    function addColumn($column)
    {
        $this->addColumns($column);
    }

    /**
     * doBarSeries - Starts a new series of data
     * This function does not need to be called if the bar graph only has one series. To set the colour of the bars if there is only one series, use setBarColour.
     *
     * @param string Name of the series, as it will appear in the legend.
     * @param int $col1 Hexadecimal colour at the top of the bar
     * @param int|bool $col2 Hexidecimal colour at the bottom of the bar, or false if no gradient is required
     */
    function doBarSeries($name, $col1 = 0xFFFFFF, $col2 = false)
    {
        if ($col2 === false) {
            $col2 = $col1;
        }

        if (!$this->using_series) {
            $this->using_series = true;
        }
        else {
            $this->series++;
        }

        $this->data[$this->series] = array();

        $this->data[$this->series]['type'] = 'bar';

        $this->data[$this->series]['name'] = $name;
        $this->data[$this->series]['col1'] = $this->hexcol($col1);
        $this->data[$this->series]['col2'] = $this->hexcol($col2);
        $this->data[$this->series]['in_legend'] = true;
        $this->data[$this->series]['data'] = array();

        $this->data[$this->series]['value_font'] = $this->value_font;
        $this->data[$this->series]['value_size'] = $this->value_size;
        $this->data[$this->series]['value_col'] = $this->value_col;
        $this->data[$this->series]['value_pos'] = $this->value_pos;
        $this->data[$this->series]['value_angle'] = $this->value_angle;
    }

    /**
     * doStackedBarSeries - Starts a new series of data, with the bars stacked on top of the last series.
     * You can stack any number of bars on top of each other by repeatedly using this function.
     *
     * @param $name Name of the series, as it will appear in the legend.
     * @param int $col1 Hexadecimal colour at the top of the bar
     * @param int $col2 (Optional) Colour at the bottom of the bar if a gradient is required
     */
    function doStackedBarSeries($name, $col1 = 0xFFFFFF, $col2 = false)
    {
        if ($col2 === false) {
            $col2 = $col1;
        }

        if (!$this->using_series) {
            $this->using_series = true;
        }
        else {
            $this->series++;
        }

        $this->data[$this->series] = array();

        $this->data[$this->series]['type'] = 'stackedbar';

        $this->data[$this->series]['name'] = $name;
        $this->data[$this->series]['col1'] = $this->hexcol($col1);
        $this->data[$this->series]['col2'] = $this->hexcol($col2);
        $this->data[$this->series]['in_legend'] = true;
        $this->data[$this->series]['data'] = array();

        $this->data[$this->series]['value_font'] = $this->value_font;
        $this->data[$this->series]['value_size'] = $this->value_size;
        $this->data[$this->series]['value_col'] = $this->value_col;
        $this->data[$this->series]['value_pos'] = $this->value_pos;
        $this->data[$this->series]['value_angle'] = $this->value_angle;
    }

    /**
     * setBarColour - Sets the colour of the bars. If two colours are specified, the bar will be coloured with a
     * gradient from the top to the bottom. If this is used after a call to doBarSeries it sets the colour for the current series.
     *
     * @param string|int $col1 Colour at the top of the bar.
     * @param string|int $col2 (Optional; default is same as $col1) Colour at the bottom of the bar.
     */
    function setBarColour($col1, $col2 = false)
    {
        if ($col2 === false) {
            $col2 = $col1;
        }
        $this->data[$this->series]['col1'] = $this->hexcol($col1);
        $this->data[$this->series]['col2'] = $this->hexcol($col2);
    }

    /**
     * setSeriesShownInLegend - Sets whether the current series should be listed in the legend.
     * @param bool $shown Whether the current series is listed.
     */
    function setSeriesShownInLegend($shown = true)
    {
        $this->data[$this->series]['in_legend'] = $shown;
    }

    /**
     * doLineSeries - Starts a new series of data, which will be drawn as a line graph.
     *
     * @param string $name Name of the series, as it will appear in the legend.
     * @param int $col Hexadecimal colour of the line
     */
    function doLineSeries($name, $col = 0x000000)
    {
        if (!$this->using_series) {
            $this->using_series = true;
        }
        else {
            $this->series++;
        }

        $this->data[$this->series] = array();

        $this->data[$this->series]['type'] = 'line';

        $this->data[$this->series]['name'] = $name;
        $this->data[$this->series]['col'] = $this->hexcol($col);
        $this->data[$this->series]['in_legend'] = true;
        $this->data[$this->series]['data'] = array();

        $this->data[$this->series]['line_thickness'] = $this->line_thickness;
        $this->data[$this->series]['line_dot_size'] = $this->line_dot_size;

        $this->data[$this->series]['value_font'] = $this->value_font;
        $this->data[$this->series]['value_size'] = $this->value_size;
        $this->data[$this->series]['value_col'] = $this->value_col;
        $this->data[$this->series]['value_pos'] = $this->value_pos;
        $this->data[$this->series]['value_angle'] = $this->value_angle;
    }

    /**
     * setLineColour - Sets the colour of the line graph, call this function after doLineSeries.
     *
     * @param string|int $col Colour of the line.
     */
    function setLineColour($col)
    {
        $this->data[$this->series]['col'] = $this->hexcol($col);
    }

    /**
     * setLineStyle - Sets the style of the line graph, call this function after doLineSeries.
     *
     * @param int $thickness (Optional; default 4) Thickness of the line in pixels.
     * @param int $dot_size (Optional; default 7) Width and height of the dots in pixels.
     */
    function setLineStyle($thickness = 4, $dot_size = 7)
    {
        if ($dot_size < 0) {
            $dot_size = 0;
        }
        if ($thickness < 0) {
            $thickness = 0;
        }

        if ($dot_size < $thickness) {
            $dot_size = $thickness;
        }

        $this->line_thickness = $thickness;
        $this->line_dot_size = $dot_size;

        $this->data[$this->series]['line_dot_size'] = $dot_size;
        $this->data[$this->series]['line_thickness'] = $thickness;
    }

    /**
     * addData - Adds a data item to the bar graph. After starting a series, add a data item for each column.
     *
     * @param string $column The name of the column this data is for.
     * @param number $value The value of this data item.
     */
    function addData($column, $value)
    {
        $this->addColumns($column);
        $this->data[$this->series]['data'][$column] = $value * 1.0;
    }

    /**
     * addDataToSeries - Adds a data item to the specified series.
     * It is often useful to create all the series first and add to them all at once,
     * instead of filling each series with all it's values in turn.
     *
     * There is an example in:
     *
     *   Documentation/bar_graph-tutorial-data.html
     *
     * @param string $series The name of the series to add this data to.
     * @param string $column The name of the column this data is for.
     * @param number $value The value of this data item.
     *
     * @return bool Returns false if the specified series does not exist, true otherwise
     */
    function addDataToSeries($series, $column, $value)
    {
        foreach ($this->data as $index => $data) {
            if ($series == $data['name']) {
                $this->addColumns($column);
                $this->data[$index]['data'][$column] = $value * 1.0;
                return true;
            }
        }

        return false;
    }

    /**
     * drawPNG - Outputs a PNG image to the web browser, including the Content-type header.
     *
     * This has the capability to create thumbnails of graphs - rendered at high res and then
     * resized down to a thumbnail size
     *
     * @example $chart->drawPNG( 500, 400 );  //  Draws a chart at 500x400 pixels, then sends it to the web browser as a PNG image.
     * @example $chart->drawPNG( 500, 400, 0, 100 );  //  Draws a chart at 500x400 pixels, then scales the image down to 100 pixels high before sending to the web browser.
     *
     * @param int $w Width of the image in pixels.
     * @param int $h Height of the image in pixels.
     * @param int $thumb_w (Optional) If you want to generate a thumbnail image sepcify either the width or the height
     * @param int $thumb_h (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     */
    function drawPNG($w, $h, $thumb_w = 0, $thumb_h = 0)
    {
        if ($w < 1) {
            $w = 1;
        }
        if ($h < 1) {
            $h = 1;
        }

        $im = $this->drawIm($w, $h);
        $im = $this->convertToThumbnail($im, $thumb_w, $thumb_h);

        //- Output PNG data

        header('Content-type: image/png');
        imagepng($im);

        imagedestroy($im);
    }

    /**
     * savePNG - Saves the chart as a PNG file.
     * The filename can be specified with an absolute path, or with a relative path, which is relative to the script which is being requested by the Web browser.
     *
     * @example $chart->savePNG( 'chart1.png', 500, 400 );  //  Saves the chart as chart1.png in the same directory as the PHP script which is being executed.
     *
     * @param string $filename Name of the file.
     * @param int $w Width of the image in pixels.
     * @param int $h Height of the image in pixels.
     * @param int $thumb_w (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     * @param int $thumb_h (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     */
    function savePNG($filename, $w, $h, $thumb_w = 0, $thumb_h = 0)
    {
        $im = $this->drawIm($w, $h);
        $im = $this->convertToThumbnail($im, $thumb_w, $thumb_h);

        //- Save PNG data

        imagepng($im, $filename);

        imagedestroy($im);
    }

    /**
     * drawJPEG - Outputs a JPEG image to the web browser, including the Content-type header.
     *
     * This has the capability to create thumbnails of graphs - rendered at high res and then
     * resized down to a thumbnail size
     *
     * @example $chart->drawJPEG( 500, 400, 90 );  //  Output a 90 pixel wide thumbnail of this chart
     *
     * @param int $w Width of the image in pixels.
     * @param int $h Height of the image in pixels.
     * @param int $quality (Optional; default 75) JPEG Quality - from 0 (lowest quality, small file) to 100 (best quality, large file)
     * @param int $thumb_w (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     * @param int $thumb_h (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     */
    function drawJPEG($w, $h, $quality = 75, $thumb_w = 0, $thumb_h = 0)
    {
        $im = $this->drawIm($w, $h);
        $im = $this->convertToThumbnail($im, $thumb_w, $thumb_h);

        //- Output JPEG data

        header('Content-type: image/jpeg');
        imagejpeg($im, NULL, $quality);

        imagedestroy($im);
    }

    /**
     * saveJPEG - Saves the chart as a JPEG file.
     * The filename can be specified with an absolute path, or with a relative path, which is relative to the script which is being requested by the Web browser.
     *
     * @example $chart->saveJPEG( 'images/charts/chart1.jpg', 500, 400 );  //  Saves the chart as chart1.jpg in the images/charts directory, relative to the PHP script which is being executed.
     *
     * @param string $filename Name of the file.
     * @param int $w Width of the image in pixels.
     * @param int $h Height of the image in pixels.
     * @param int $quality (Optional; default 75) JPEG Quality - from 0 (lowest quality, small file) to 100 (best quality, large file)
     * @param int $thumb_w (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     * @param int $thumb_h (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     */
    function saveJPEG($filename, $w, $h, $quality = 75, $thumb_w = 0, $thumb_h = 0)
    {
        $im = $this->drawIm($w, $h);
        $im = $this->convertToThumbnail($im, $thumb_w, $thumb_h);

        //- Save JPEG data

        imagejpeg($im, $filename, $quality);

        imagedestroy($im);
    }

    /**
     * drawIm - Internal function which takes care of rendering the graph to a GD image
     *
     * @param int $w The width of the image to generate
     * @param int $h The height of the image to generate
     *
     * @return resource The GD image containing the chart
     */
    private function drawIm($w, $h)
    {
        $w = intval($w);
        $h = intval($h);

        //- Set up image

        $im = imagecreatetruecolor($w, $h);
        imagealphablending($im, true);
        if (function_exists('imageantialias')) {
            imageantialias($im, false);
        }

        $chart_bounds = $this->drawTitleAndLegend($im, $w, $h);

        list($axis_size, $ymin, $ymax, $yscale) = $this->calculateAxisSizes($chart_bounds);

        //- Draw layers

        $this->drawChartBackground($im, $ymin, $ymax, $yscale, $chart_bounds, $axis_size);
        $this->drawAxes($im, $ymin, $ymax, $yscale, $chart_bounds, $axis_size);
        $this->drawGraph($im, $ymin, $ymax, $yscale, $chart_bounds, $axis_size);

        return $im;
    }

    /**
     * drawChartBackground - Internal function to render the background
     *
     * @param resource $im
     * @param number $ymin
     * @param number $ymax
     * @param number $yscale
     * @param array $chart_bounds
     * @param array $axis_size
     */
    private function drawChartBackground($im, $ymin, $ymax, $yscale, $chart_bounds, $axis_size)
    {
        $chart_x1 = $chart_bounds[0] + $axis_size[0];
        $chart_y1 = $chart_bounds[1] + $axis_size[3];
        $chart_x2 = $chart_bounds[2] - $axis_size[2];
        $chart_y2 = $chart_bounds[3] - $axis_size[1];

        $chart_w = $chart_x2 - $chart_x1;
        $chart_h = $chart_y2 - $chart_y1;

        //  Background

        imagefilledrectangle($im, $chart_x1, $chart_y1, $chart_x2, $chart_y2, 0x30FFFFFF);
    }

    /**
     * drawAxes - Internal function to draw the axes of the chart
     *
     * @param resource $im
     * @param number $ymin
     * @param number $ymax
     * @param number $yscale
     * @param array $chart_bounds
     * @param array $axis_size
     */
    private function drawAxes($im, $ymin, $ymax, $yscale, $chart_bounds, $axis_size)
    {
        $xaxis_font = $this->getFont($this->xaxis_font);
        $xaxis_font_size = $this->xaxis_font_size;
        $xaxis_font_col = $this->xaxis_font_col;
        $xaxis_font_angle = -$this->xaxis_font_angle;

        $yaxis_font = $this->getFont($this->yaxis_font);
        $yaxis_font_size = $this->yaxis_font_size;
        $yaxis_font_col = $this->yaxis_font_col;

        $chart_x1 = $chart_bounds[0] + $axis_size[0];
        $chart_y1 = $chart_bounds[1] + $axis_size[3];
        $chart_x2 = $chart_bounds[2] - $axis_size[2];
        $chart_y2 = $chart_bounds[3] - $axis_size[1];

        $chart_w = $chart_x2 - $chart_x1;
        $chart_h = $chart_y2 - $chart_y1;

        $column_count = count($this->columns);

        $grid_x_drawn = false;
        $grid_y_drawn = false;

        $xaxis_font_align_tweak = -$xaxis_font_angle / 45;

        for ($axis_index = 0; $axis_index < 4; $axis_index++) {
            $opposite = ($axis_index + 2) % 4; //  Axis index of opposite axis

            if ($axis_size[$axis_index] > 0) {
                $this->drawAxisTitle($im, $axis_index, $chart_bounds, $axis_size, $this->axis_data[$axis_index]['t']);

                if ($this->axis_data[$axis_index]['a'] == 'x') {
                    if ($axis_index == 0) {
                        imageline($im, $chart_x1, $chart_y1, $chart_x1, $chart_y2, 0x000000);

                        if ($column_count > 0)
                            for ($i = 0; $i <= $column_count; $i++) {
                                $y = $chart_y1 + $chart_h * $i / $column_count;
                                imageline($im, $chart_x1 - 5, $y, $chart_x1, $y, 0x000000);
                                if (!$grid_x_drawn)
                                    imageline($im, $chart_x1, $y, $chart_x2, $y, 0x72000000);
                                if ($i < $column_count) {
                                    $y = $chart_y1 + $chart_h * ($i + 0.5) / $column_count;
                                    $this->drawAlignedText($im, $chart_x1 - 3, $y, 1, 0.5, $xaxis_font, $xaxis_font_size, $xaxis_font_col, $this->columns[$i], $xaxis_font_angle, $xaxis_font_align_tweak);
                                }
                            }
                    }
                    else if ($axis_index == 1) {
                        imageline($im, $chart_x1, $chart_y2, $chart_x2, $chart_y2, 0x000000);

                        if ($column_count > 0)
                            for ($i = 0; $i <= $column_count; $i++) {
                                $x = $chart_x1 + $chart_w * $i / $column_count;
                                imageline($im, $x, $chart_y2, $x, $chart_y2 + 5, 0x000000);
                                if (!$grid_x_drawn)
                                    imageline($im, $x, $chart_y1, $x, $chart_y2, 0x72000000);
                                if ($i < $column_count) {
                                    $x = $chart_x1 + $chart_w * ($i + 0.5) / $column_count;
                                    $this->drawAlignedText($im, $x, $chart_y2 + 3, 0.5, 0, $xaxis_font, $xaxis_font_size, $xaxis_font_col, $this->columns[$i], $xaxis_font_angle, $xaxis_font_align_tweak);
                                }
                            }
                    }
                    else if ($axis_index == 2) {
                        imageline($im, $chart_x2, $chart_y1, $chart_x2, $chart_y2, 0x000000);

                        if ($column_count > 0)
                            for ($i = 0; $i <= $column_count; $i++) {
                                $y = $chart_y1 + $chart_h * $i / $column_count;
                                imageline($im, $chart_x2, $y, $chart_x2 + 5, $y, 0x000000);
                                if (!$grid_x_drawn)
                                    imageline($im, $chart_x1, $y, $chart_x2, $y, 0x72000000);
                                if ($i < $column_count) {
                                    $x = $chart_x2 + 3;
                                    //                 $x += $this->getTextLineHeight( $xaxis_font, $xaxis_font_size );
                                    $y = $chart_y1 + $chart_h * ($i + 0.5) / $column_count;
                                    $this->drawAlignedText($im, $x, $y, 0, 0.5, $xaxis_font, $xaxis_font_size, $xaxis_font_col, $this->columns[$i], $xaxis_font_angle, $xaxis_font_align_tweak);
                                }
                            }
                    }
                    else if ($axis_index == 3) {
                        imageline($im, $chart_x1, $chart_y1, $chart_x2, $chart_y1, 0x000000);

                        if ($column_count > 0)
                            for ($i = 0; $i <= $column_count; $i++) {
                                $x = $chart_x1 + $chart_w * $i / $column_count;

                                imageline($im, $x, $chart_y1 - 5, $x, $chart_y1, 0x000000);

                                if (!$grid_x_drawn)
                                    imageline($im, $x, $chart_y1, $x, $chart_y2, 0x72000000);

                                if ($i < $column_count) {
                                    $y = $chart_y1 - 3;
                                    $y -= $this->getTextLineHeight($xaxis_font, $xaxis_font_size);
                                    $x = $chart_x1 + $chart_w * ($i + 0.5) / $column_count;
                                    $this->drawAlignedText($im, $x, $y, 0.5, 0, $xaxis_font, $xaxis_font_size, $xaxis_font_col, $this->columns[$i], $xaxis_font_angle, $xaxis_font_align_tweak);
                                }
                            }
                    }

                    $grid_x_drawn = true;
                }
                else if ($this->axis_data[$axis_index]['a'] == 'y') {
                    if ($axis_index == 0) //  Y Axis on Left
                    {
                        imageline($im, $chart_x1, $chart_y1, $chart_x1, $chart_y2, 0x000000);

                        $i = $this->getYAxisFirst($ymin, $ymax, $yscale);

                        while ($i <= $ymax) {
                            $y = $chart_y2 - $chart_h * ($i - $ymin) / ($ymax - $ymin);
                            imageline($im, $chart_x1 - 5, $y, $chart_x1, $y, 0x000000);
                            $this->drawAlignedText($im, $chart_x1 - 8, $y, 1, 0.5, $yaxis_font, $yaxis_font_size, $yaxis_font_col, $i);
                            if (!$grid_y_drawn)
                                imageline($im, $chart_x1, $y, $chart_x2, $y, $i == 0 ? 0x38000000 : 0x72000000);
                            $i += $this->getYAxisStep($ymin, $ymax, $yscale);
                        }
                    }
                    else if ($axis_index == 1) {
                        imageline($im, $chart_x1, $chart_y2, $chart_x2, $chart_y2, 0x000000);

                        $i = $this->getYAxisFirst($ymin, $ymax, $yscale);

                        while ($i <= $ymax) {
                            $x = $chart_x1 + $chart_w * ($i - $ymin) / ($ymax - $ymin);
                            imageline($im, $x, $chart_y2, $x, $chart_y2 + 5, 0x000000);
                            $this->drawAlignedText($im, $x, $chart_y2 + 8, 0.5, 0, $yaxis_font, $yaxis_font_size, $yaxis_font_col, $i);
                            if (!$grid_y_drawn)
                                imageline($im, $x, $chart_y1, $x, $chart_y2, $i == 0 ? 0x38000000 : 0x72000000);
                            $i += $this->getYAxisStep($ymin, $ymax, $yscale);
                        }
                    }
                    else if ($axis_index == 2) //  Y Axis on Right
                    {
                        imageline($im, $chart_x2, $chart_y1, $chart_x2, $chart_y2, 0x000000);

                        $i = $this->getYAxisFirst($ymin, $ymax, $yscale);
                        while ($i <= $ymax) {
                            $y = $chart_y2 - $chart_h * ($i - $ymin) / ($ymax - $ymin);
                            imageline($im, $chart_x2, $y, $chart_x2 + 5, $chart_y2 - $chart_h * $i / $ymax, 0x000000);
                            $this->drawAlignedText($im, $chart_x2 + 8, $y, 0, 0.5, $yaxis_font, $yaxis_font_size, $yaxis_font_col, $i);
                            if (!$grid_y_drawn)
                                imageline($im, $chart_x1, $y, $chart_x2, $y, $i == 0 ? 0x38000000 : 0x72000000);
                            $i += $this->getYAxisStep($ymin, $ymax, $yscale);
                        }
                    }
                    else if ($axis_index == 3) {
                        imageline($im, $chart_x1, $chart_y1, $chart_x2, $chart_y1, 0x000000);

                        $i = $this->getYAxisFirst($ymin, $ymax, $yscale);
                        while ($i <= $ymax) {
                            $x = $chart_x1 + $chart_w * ($i - $ymin) / ($ymax - $ymin);
                            imageline($im, $x, $chart_y1 - 5, $x, $chart_y1, 0x000000);
                            $this->drawAlignedText($im, $x, $chart_y1 - 8, 0.5, 1, $yaxis_font, $yaxis_font_size, $yaxis_font_col, $i);
                            if (!$grid_y_drawn)
                                imageline($im, $x, $chart_y1, $x, $chart_y2, $i == 0 ? 0x38000000 : 0x72000000);
                            $i += $this->getYAxisStep($ymin, $ymax, $yscale);
                        }
                    }

                    $grid_y_drawn = true;
                }
            }
        }
    }

    /**
     * drawAxisTitle - Internal function to draw titles on axes
     *
     * @param resource $im
     * @param int $i
     * @param array $chart_bounds
     * @param array $axis_size
     * @param string $t
     *
     * @return int
     */
    private function drawAxisTitle($im, $i, $chart_bounds, $axis_size, $t)
    {
        if ($t == '') {
            return 0;
        }

        $opposite = ($i + 2) % 4;

        $font = $this->getFont($this->axis_data[$i]['a'] == 'x' || $this->axis_data[$opposite]['a'] == 'x' ? $this->xaxis_title_font : $this->yaxis_title_font);
        $size = $this->axis_data[$i]['a'] == 'x' || $this->axis_data[$opposite]['a'] == 'x' ? $this->xaxis_title_font_size : $this->yaxis_title_font_size;
        $col = $this->axis_data[$i]['a'] == 'x' || $this->axis_data[$opposite]['a'] == 'x' ? $this->xaxis_title_font_col : $this->yaxis_title_font_col;

        if ($i == 0) {
            $w = $chart_bounds[3] - $chart_bounds[1] - $axis_size[1] - $axis_size[3];
            $x = $chart_bounds[0];
            $y = ($chart_bounds[1] + $axis_size[3] + $chart_bounds[3] - $axis_size[1]) * 0.5;

            $t = $this->getWrappedText($font, $size, $w, $t);
            $lh = $this->getTextLineHeight($font, $size);

            foreach ($t as $line) {
                $this->drawAlignedText($im, $x, $y, 0, 0.5, $font, $size, $col, $line, 90);
                $x += $lh;
            }
        }
        else if ($i == 1) {
            $w = $chart_bounds[2] - $chart_bounds[0] - $axis_size[0] - $axis_size[2];
            $x = ($chart_bounds[2] + $axis_size[0] + $chart_bounds[0] - $axis_size[2]) * 0.5;
            $y = $chart_bounds[3];

            $t = $this->getWrappedText($font, $size, $w, $t);

            $this->drawAlignedText($im, $x, $y, 0.5, 1, $font, $size, $col, join("\n", $t), 0);
        }
        else if ($i == 2) {
            $w = $chart_bounds[3] - $chart_bounds[1] - $axis_size[1] - $axis_size[3];
            $x = $chart_bounds[2];
            $y = ($chart_bounds[1] + $axis_size[3] + $chart_bounds[3] - $axis_size[1]) * 0.5;

            $t = $this->getWrappedText($font, $size, $w, $t);

            $this->drawAlignedText($im, $x, $y, 1, 0.5, $font, $size, $col, join("\n", $t), 90);
        }
        else if ($i == 3) {
            $w = $chart_bounds[2] - $chart_bounds[0] - $axis_size[0] - $axis_size[2];
            $x = ($chart_bounds[2] + $axis_size[0] + $chart_bounds[0] - $axis_size[2]) * 0.5;
            $y = $chart_bounds[1];

            $t = $this->getWrappedText($font, $size, $w, $t);

            $this->drawAlignedText($im, $x, $y, 0.5, 0, $font, $size, $col, join("\n", $t), 0);
        }

        return 0;
    }

    /**
     * drawGraph - Internal function to render the graph
     * @param resource $im
     * @param number $ymin
     * @param number $ymax
     * @param number $yscale
     * @param array $chart_bounds
     * @param array $axis_size
     *
     * @return mixed
     */
    private function drawGraph($im, $ymin, $ymax, $yscale, $chart_bounds, $axis_size)
    {
        //- Get params

        $column_spacing = 0.01 * $this->column_spacing;
        $bar_spacing = 0.01 * $this->bar_spacing;

        $series_count = count($this->data);
        $column_count = count($this->columns);

        $num_stacks = $this->getNumStacks();

        $line_dot_size = 0;

        $chart_x1 = $chart_bounds[0] + $axis_size[0];
        $chart_y1 = $chart_bounds[1] + $axis_size[3];
        $chart_x2 = $chart_bounds[2] - $axis_size[2];
        $chart_y2 = $chart_bounds[3] - $axis_size[1];

        $chart_w = $chart_x2 - $chart_x1;
        $chart_h = $chart_y2 - $chart_y1;

//        imagefilledrectangle( $im, $chart_x1, $chart_y1, $chart_x2, $chart_y2, 0x30FFFFFF );

        if ($column_count > 0) {
            //- Draw bars

            $bar_position = array();

            //  Array which will contain cumulative heights of columns

            $column_height = array();
            foreach ($this->columns as $column) {
                $column_height[$column] = 0;
            }

            //  Array which will hold the downward extent (total of all negative data values)

            $column_depth = array();
            foreach ($this->columns as $column) {
                $column_depth[$column] = 0;
            }

            $current_stack = 0; //  Current stack to draw (0 is initial value; first stack is #1)

            $a = $num_stacks + $bar_spacing * ($num_stacks - 1) + $column_spacing * 2; //  Width of column in multiple of bar widths

            if ($a < 1)
                $a = 1;

            if ($this->getHorizontalOrientation()) {
                $column_w = 0;
                $column_h = $chart_h / $column_count;

                $bar_start = 0;
                $bar_width = $column_h;
                $bar_step = 0;

                $bar_start = $column_h * $column_spacing / $a;
                $bar_width = $column_h / $a;
                $bar_step = $column_h * (1 + $bar_spacing) / $a;
            }
            else {
                $column_w = $chart_w / $column_count;
                $column_h = 0;

                $bar_start = 0;
                $bar_width = $column_w;
                $bar_step = 0;

                $bar_start = $column_w * $column_spacing / $a;
                $bar_width = $column_w / $a;
                $bar_step = $column_w * (1 + $bar_spacing) / $a;
            }

            foreach ($this->data as $series_id => $series) {
                $type = $series['type'];
                $data = $series['data'];

                //  If it's a bar series then reset the column heights

                if ($type == 'bar') {
                    foreach ($this->columns as $column) {
                        $column_height[$column] = 0;
                    }
                    foreach ($this->columns as $column) {
                        $column_depth[$column] = 0;
                    }
                    $current_stack++;
                }

                if ($type == 'bar' || $type == 'stackedbar') {
                    if ($current_stack < 1)
                        $current_stack = 1;

                    foreach ($this->columns as $i => $column) {
                        $value = isset($data[$column])?$data[$column]:0;

                        if ($this->getHorizontalOrientation()) //  Bar chart is horizontal
                        {
                            $bar_y1 = intval(0.5 + $chart_y1 + $i * $column_h + $bar_start + $bar_step * ($current_stack - 1));
                            $bar_y2 = intval(0.5 + $chart_y1 + $i * $column_h + $bar_start + $bar_step * ($current_stack - 1) + $bar_width);

                            if ($value >= 0) {
                                $bar_x1 = intval($chart_x1 + ($column_height[$column] - $ymin) * $chart_w / ($ymax - $ymin));
                                $bar_x2 = intval($chart_x1 + ($column_height[$column] - $ymin + (isset($data[$column])?$data[$column]:0)) * $chart_w / ($ymax - $ymin));
                            }
                            else {
                                $bar_x1 = intval($chart_x1 + ($column_depth[$column] - $ymin + (isset($data[$column])?$data[$column]:0)) * $chart_w / ($ymax - $ymin));
                                $bar_x2 = intval($chart_x1 + ($column_depth[$column] - $ymin) * $chart_w / ($ymax - $ymin));
                            }

                            if ($bar_y1 < $chart_y1)
                                $bar_y1 = $chart_y1;

                            if ($bar_y2 > $bar_y1 && $bar_y2 > $chart_y1) //  Only draw if it is within visible area of graph
                            {
                                if (!isset($bar_position[$series_id]))
                                    $bar_position[$series_id] = array();
                                $bar_position[$series_id][$column] = array($bar_x1, $bar_y1, $bar_x2, $bar_y2);

                                $this->drawHShadedRectangle($im, $bar_x1, $bar_y1, $bar_x2 - 1, $bar_y2 - 1, $series['col1'], $series['col2']);

                                //  Do shading

                                for ($j = $bar_y1; $j < $bar_y2; $j++) {
                                    $s = ($j - $bar_y1) / ($bar_y2 - $bar_y1);
                                    $s = ($s - 0.25) * ($s - 0.25);
                                    $s = 127 - intval($s * 127);
                                    imageline($im, $bar_x1, $j, $bar_x2 - 1, $j, ($s << 24));
                                }

                                //  Border

                                if (intval($bar_y2) != intval($bar_y1))
                                    imagerectangle($im, $bar_x1, $bar_y1, $bar_x2, $bar_y2, 0x000000);
                            }
                        }
                        else //  Bar chart is vertical
                        {
                            $bar_x1 = intval(0.5 + $chart_x1 + $i * $column_w + $bar_start + $bar_step * ($current_stack - 1));
                            $bar_x2 = intval(0.5 + $chart_x1 + $i * $column_w + $bar_start + $bar_step * ($current_stack - 1) + $bar_width);

                            if ($value >= 0) {
                                $bar_y1 = intval($chart_y2 - ($column_height[$column] - $ymin + $value) * $chart_h / ($ymax - $ymin));
                                $bar_y2 = intval($chart_y2 - ($column_height[$column] - $ymin) * $chart_h / ($ymax - $ymin));
                            }
                            else {
                                $bar_y1 = intval($chart_y2 - ($column_depth[$column] - $ymin) * $chart_h / ($ymax - $ymin));
                                $bar_y2 = intval($chart_y2 - ($column_depth[$column] - $ymin + $value) * $chart_h / ($ymax - $ymin));
                            }

                            if ($bar_y1 < $chart_y1)
                                $bar_y1 = $chart_y1;

                            if ($bar_y2 > $bar_y1 && $bar_y2 > $chart_y1) //  Only draw if it is within visible area of graph
                            {
                                if (!isset($bar_position[$series_id]))
                                    $bar_position[$series_id] = array();
                                $bar_position[$series_id][$column] = array($bar_x1, $bar_y1, $bar_x2, $bar_y2);

                                $this->drawVShadedRectangle($im, $bar_x1, $bar_y1, $bar_x2 - 1, $bar_y2 - 1, $series['col1'], $series['col2']);

                                //  Do shading

                                $bar_w = $bar_x2 - $bar_x1;
                                if ($bar_w < 1)
                                    $bar_w = 1;

                                for ($j = $bar_x1; $j < $bar_x2; $j++) {
                                    $s = ($j - $bar_x1) / ($bar_w);
                                    $s = ($s - 0.25) * ($s - 0.25);
                                    $s = 127 - intval($s * 127);
                                    imageline($im, $j, $bar_y1, $j, $bar_y2 - 1, ($s << 24));
                                }

                                //  Border

                                if (intval($bar_y2) != intval($bar_y1))
                                    imagerectangle($im, $bar_x1, $bar_y1, $bar_x2, $bar_y2, 0x000000);
                            }
                        }

                        if ($value > 0) {
                            $column_height[$column] += $value;
                        }
                        else if ($value < 0) {
                            $column_depth[$column] += $value;
                        }
                    }
                }
                else //  Line
                {
                    //  First pass = black border, 2nd pass = coloured line and blobs

                    for ($pass = 0; $pass < 2; $pass++) {
                        $col = $pass == 0 ? 0x000000 : $this->hexcol($series['col']);

                        $line_dot_size = $series['line_dot_size'] * 0.5 + 0.75 * (1.0 - $pass);
                        $line_thickness = $series['line_thickness'] + 1.5 * (1.0 - $pass);

                        $x = false;
                        $y = false;

                        foreach ($this->columns as $i => $column) {
                            $ox = $x;
                            $oy = $y;

                            $value = (isset($data[$column])?$data[$column]:0);

                            if ($this->getHorizontalOrientation()) //  Bar chart is horizontal
                            {
                                $y = $chart_y1 + ($i + 0.5) * $column_h;
                                $x = $chart_x2 - ($value - $ymin) * $chart_w / ($ymax - $ymin);
                            }
                            else {
                                $x = $chart_x1 + ($i + 0.5) * $column_w;
                                $y = $chart_y2 - ($value - $ymin) * $chart_h / ($ymax - $ymin);
                            }

                            if (!isset($bar_position[$series_id]))
                                $bar_position[$series_id] = array();
                            $bar_position[$series_id][$column] = array($x, $y, $x, $y);

                            $this->drawShadedElipse($im, $x, $y, $line_dot_size, $line_dot_size, $col);
                            if ($ox !== false)
                                $this->drawThickLine($im, $ox, $oy, $x, $y, $line_thickness, $col);
                        }
                    }
                }
            }
        }

        //  Draw value labels

        foreach ($this->data as $series_id => $series) {
            foreach ($this->columns as $column) {
                $font = $this->getFont($series['value_font']);

                if ($font !== false) {
                    if (isset($bar_position[$series_id][$column])) {
                        $bar_x1 = $bar_position[$series_id][$column][0];
                        $bar_y1 = $bar_position[$series_id][$column][1];
                        $bar_x2 = $bar_position[$series_id][$column][2];
                        $bar_y2 = $bar_position[$series_id][$column][3];

                        $spacing = 4;

                        if ($series['type'] == 'line')
                            $spacing += $line_dot_size;

                        if ($series['value_pos'] == 1) {
                            $this->drawAlignedText($im, ($bar_x1 + $bar_x2) * 0.5, $bar_y1 - $spacing, 0.5, 1, $font, $series['value_size'], $series['value_col'], $series['data'][$column], $series['value_angle']);
                        }
                        else if ($series['value_pos'] == 2) {
                            $this->drawAlignedText($im, ($bar_x1 + $bar_x2) * 0.5, $bar_y1 + $spacing + 2, 0.5, 0, $font, $series['value_size'], $series['value_col'], $series['data'][$column], $series['value_angle']);
                        }
                        else if ($series['value_pos'] == 3) {
                            $this->drawAlignedText($im, ($bar_x1 + $bar_x2) * 0.5, ($bar_y1 + $bar_y2) * 0.5, 0.5, 0.5, $font, $series['value_size'], $series['value_col'], $series['data'][$column], $series['value_angle']);
                        }
                        else if ($series['value_pos'] == 4) {
                            $this->drawAlignedText($im, ($bar_x1 + $bar_x2) * 0.5, $bar_y2 - $spacing, 0.5, 1, $font, $series['value_size'], $series['value_col'], $series['data'][$column], $series['value_angle']);
                        }
                    }
                }
            }
        }

        //- Return image

        return $im;
    }

    /**
     * drawTitleAndLegend - Internal function to draw the title and legend for the graph
     *
     * @param resource $im
     * @param int $w
     * @param int $h
     *
     * @return array
     */
    private function drawTitleAndLegend($im, $w, $h)
    {
        //- Bar chart parameters

        $legend_width = $this->legend_width * 0.01;
        $legend_valign = $this->legend_ypos; //  -1 = top, 0 = middle, 1 = bottom
        $legend_pos = $this->legend_xpos; //  0=left, 1=right

        $padding = $this->padding; //  Padding inside image

        $legend_bg = $this->legend_bg;
        $legend_border = $this->legend_border;
        $legend_box_padding = $this->legend_box_padding;
        $legend_between_padding = $this->legend_between_padding;
        $legend_key_padding = $this->legend_key_padding;
        $legend_key_size = $this->legend_key_size;
        $legend_font = $this->getFont($this->legend_font);
        $legend_font_size = $this->legend_font_size;
        $legend_font_col = $this->legend_font_col;

        $title_pos = $this->title_ypos; //  0=top, 1=bottom
        $title_halign = $this->title_xpos; //  -1=left, 0=middle, 1=right
        $title_font = $this->getFont($this->title_font);
        $title_font_size = $this->title_font_size;
        $title_col = $this->title_col;

        //- Draw background

        for ($i = 0; $i < $h; $i++) {
            $c = $this->colourBlend($this->bg1, $this->bg2, $i / $h);
            imagefilledrectangle($im, 0, $i, $w - 1, $i, $c);
        }

        //- Draw title

        $title_h = 0;

        if ($this->title != '') {
            $title_lines = $this->getWrappedText($title_font, $title_font_size, $w - $padding * 2, $this->title);

            $title_box = $this->getTextBoundingBox($title_font_size, 0, $title_font, join("\n", $title_lines));

            $title_h = $title_box[1] - $title_box[5];

            $box = $this->getTextBoundingBox($title_font_size, 0, $title_font, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
            $top = -$box[5];
            $line_h = $box[1] - $box[5];

            $box = $this->getTextBoundingBox($title_font_size, 0, $title_font, "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz\nABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
            $line_spacing = $box[1] - $box[5] - $line_h * 2;

            if ($title_pos == 0) {
                $y = $padding + $top;
            }
            else {
                $y = $h - $padding - $title_h + $top;
            }

            if ($title_halign < 0) {
                imagettftext($im, $title_font_size, 0, $padding, $y, $title_col, $title_font, join("\n", $title_lines));
            }
            else if ($title_halign > 0) {
                foreach ($title_lines as $line) {
                    $box = $this->getTextBoundingBox($title_font_size, 0, $title_font, $line);
                    $box_w = $box[2] - $box[0];

                    $x = $w - $padding - $box_w;
                    imagettftext($im, $title_font_size, 0, $x, $y, $title_col, $title_font, $line);
                    $y += $box[1] - $box[5] + $line_spacing;
                }
            }
            else {
                foreach ($title_lines as $line) {
                    $box = $this->getTextBoundingBox($title_font_size, 0, $title_font, $line);
                    $box_w = $box[2] - $box[0];

                    $x = ($w - $box_w) * 0.5;
                    imagettftext($im, $title_font_size, 0, $x, $y, $title_col, $title_font, $line);
                    $y += $box[1] - $box[5] + $line_spacing;
                }
            }

            $title_h += $padding;
        }

        //- Draw legend

        if ($this->using_series && $legend_width > 0) {
            if ($legend_pos == 0) {
                $legend_x1 = $padding;
                $legend_x2 = intval($w * ($legend_width) - $padding * 0.5);
            }
            else {
                $legend_x1 = intval($w * (1 - $legend_width) + $padding * 0.5);
                $legend_x2 = intval($w - $padding);
            }

            //  Work out height based on fonts and word-wrapping

            $text_h = 0;
            $text_array = array();

            $n = count($this->data);

            $count_in_legend = 0;

            for ($i = 0; $i < $n; $i++) {
                if ($this->data[$i]['in_legend']) {
                    $lines = $this->getWrappedText($legend_font, $legend_font_size, $legend_x2 - $legend_x1 - $legend_box_padding * 2 - $legend_key_padding - $legend_key_size, $this->data[$i]['name']);

                    $box = $this->getTextBoundingBox($legend_font_size, 0, $legend_font, join("\n", $lines));
                    $box_h = $box[1] - $box[5];

                    if ($box_h < $legend_key_size) {
                        $box_h = $legend_key_size;
                    }
                    $text_h += $box_h;

                    $text_array[] = array('height' => $box_h,
                        'lines' => $lines);

                    $count_in_legend++;
                }
                else {
                    $text_array[] = false; //  Add dummy entries so this array can be indexed sensibly
                }
            }

            $legend_h = $legend_box_padding * 2 + $text_h + $legend_between_padding * ($count_in_legend - 1);

            if ($legend_valign < 0) //  Top
            {
                $legend_y1 = intval($padding);

                if ($title_pos == 0) {
                    $legend_y1 += $title_h;
                }
            }
            else if ($legend_valign == 0) //  Middle
            {
                $legend_y1 = ($h - $legend_h) * 0.5;

                if ($title_pos == 0) {
                    $legend_y1 += $title_h / 2;
                }
                else {
                    $legend_y1 -= $title_h / 2;
                }
            }
            else //  Bottom
            {
                $legend_y1 = $h - $legend_h - intval($padding);

                if ($title_pos != 0) {
                    $legend_y1 -= $title_h;
                }
            }

            $legend_y2 = $legend_y1 + $legend_h;

            //  Background

            imagefilledrectangle($im, $legend_x1, $legend_y1, $legend_x2, $legend_y2, $legend_bg);
            imagerectangle($im, $legend_x1, $legend_y1, $legend_x2, $legend_y2, $legend_border);

            //  Coloured boxes and text

            $x1 = $legend_x1 + $legend_box_padding;
            $y1 = $legend_y1 + $legend_box_padding;

            $box = $this->getTextBoundingBox($legend_font_size, 0, $legend_font, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789,.');
            $line_top = -$box[5];

            for ($i = 0; $i < $n; $i++) {
                if ($this->data[$i]['in_legend']) {
                    $type = $this->data[$i]['type'];

                    if ($type == 'bar' || $type == 'stackedbar') {
                        $col1 = $this->data[$i]['col1'];
                        $col2 = $this->data[$i]['col2'];
                    }
                    else {
                        $col1 = $col2 = $this->data[$i]['col'];
                    }

                    $this->drawVShadedRectangle($im, $x1, $y1, $x1 + $legend_key_size, $y1 + $legend_key_size, $col1, $col2);
                    imagerectangle($im, $x1, $y1, $x1 + $legend_key_size, $y1 + $legend_key_size, 0x000000);

                    imagettftext($im, $legend_font_size, 0, $x1 + $legend_key_size + $legend_key_padding, $y1 + $line_top, $legend_font_col, $legend_font, join("\n", $text_array[$i]['lines']));

                    $box_h = $text_array[$i]['height'];
                    if ($box_h < $legend_key_size) {
                        $box_h = $legend_key_size;
                    }

                    $y1 += $box_h + $legend_between_padding;
                }
            }
        } //  if using series

        //- Draw chart

        //- Calculate bounding box

        $chart_y1 = intval($padding);
        $chart_y2 = intval($h - $padding);

        $chart_x1 = intval($padding);
        $chart_x2 = intval($w - $padding);

        if ($this->using_series && $legend_width > 0) {
            if ($legend_pos == 0) {
                $chart_x1 = intval($w * ($legend_width) + $padding * 0.5);
            }
            else {
                $chart_x2 = intval($w * (1 - $legend_width) - $padding * 0.5);
            }
        }

        if ($title_pos == 0) {
            $chart_y1 += $title_h;
        }
        else {
            $chart_y2 -= $title_h;
        }

        return array($chart_x1, $chart_y1, $chart_x2, $chart_y2);
    }

    /**
     * isXAxisOffset - Internal method.
     * Returns whether the labels in the X Axis are on (false) or between the gridlines (true)
     *
     * @return bool
     */
    private function isXAxisOffset()
    {
        foreach ($this->data as $series) {
            if ($series['type'] == 'bar' || $series['type'] == 'stackedbar') {
                return true;
            }
        }
        return false;
    }

    /**
     * calculateAxisSizes - Internal function to calculate the dimensions of the axes for rednering
     * @param array $chart_bounds
     * @return array
     */
    private function calculateAxisSizes($chart_bounds)
    {
        //- Work out how the chart_bounds is divided up...

        if ($this->yaxis_max !== false) {
            $ymax = $this->yaxis_max;
        }
        else {
            $ymax = $this->getYMax();
            $ymax *= 1.2; //  scale factor
        }

        if ($this->yaxis_min !== false) {
            $ymin = $this->yaxis_min;
        }
        else {
            $ymin = $this->getYMin();
            $ymin *= 1.2; //  scale factor
        }

        //  If the range is too small, increase it

        if ($ymax - $ymin < 0.0001)
            $ymax += 1.0;

        //  Iterate a few times to allow the values to settle down

        for ($yscale = 0.001; $yscale < $ymax; $yscale *= 10) {
        }

        $axis_size = array(0, 0, 0, 0);

        $axis_size = $this->getAxisSizes($ymin, $ymax, $yscale, $axis_size, $chart_bounds);
        list($ymin, $ymax, $yscale) = $this->adjustYRange($ymin, $ymax, $yscale, $axis_size, $chart_bounds);
        $axis_size = $this->getAxisSizes($ymin, $ymax, $yscale, $axis_size, $chart_bounds);
        list($ymin, $ymax, $yscale) = $this->adjustYRange($ymin, $ymax, $yscale, $axis_size, $chart_bounds);
        $axis_size = $this->getAxisSizes($ymin, $ymax, $yscale, $axis_size, $chart_bounds);

        return array($axis_size, $ymin, $ymax, $yscale);
    }

    /**
     * getAxisSize - Internal functon to get the width/height of an axis
     *
     * @param int $axis_index
     * @param number $ymin
     * @param number $ymax
     * @param number $yscale
     * @param array $axis_size
     * @param array$chart_bounds
     *
     * @return int
     */
    private function getAxisSize($axis_index, $ymin, $ymax, $yscale, $axis_size, $chart_bounds)
    {
        //  Work out title box area if necessary

        if ($axis_index == 0) {
            $bound = $this->getAxisTitleDepth($axis_index, $chart_bounds[3] - $chart_bounds[1] - $axis_size[1] - $axis_size[3]);
        }
        else if ($axis_index == 1) {
            $bound = $this->getAxisTitleDepth($axis_index, $chart_bounds[2] - $chart_bounds[0] - $axis_size[0] - $axis_size[2]);
        }
        else if ($axis_index == 2) {
            $bound = $this->getAxisTitleDepth($axis_index, $chart_bounds[3] - $chart_bounds[1] - $axis_size[1] - $axis_size[3]);
        }
        else {
            $bound = $this->getAxisTitleDepth($axis_index, $chart_bounds[2] - $chart_bounds[0] - $axis_size[0] - $axis_size[2]);
        }

        //  Now work out the width/height of the axis with it's labels

        if ($this->axis_data[$axis_index]['a'] == 'x') {
            $bound += $axis_index == 0 || $axis_index == 2 ? $this->getXAxisWidth($ymin, $ymax, $yscale) : $this->getXAxisHeight($ymin, $ymax, $yscale);
        }
        else if ($this->axis_data[$axis_index]['a'] == 'y') {
            $bound += $axis_index == 0 || $axis_index == 2 ? $this->getYAxisWidth($ymin, $ymax, $yscale) : $this->getYAxisHeight($ymin, $ymax, $yscale);
        }

        return $bound;
    }

    /**
     * @param $axis_index
     * @param $w
     * @param bool $include_padding
     * @return int
     */
    private function getAxisTitleDepth($axis_index, $w, $include_padding = true)
    {
        $text = $this->axis_data[$axis_index]['t'];

        if ($text == '') {
            return 0;
        }

        $font = $this->getFont($this->axis_data[$axis_index]['a'] == 'x' ? $this->xaxis_title_font : $this->yaxis_title_font);
        $size = $this->axis_data[$axis_index]['a'] == 'x' ? $this->xaxis_title_font_size : $this->yaxis_title_font_size;

        $th = $this->getWrappedTextHeight($font, $size, $w, $text);

        $d = $th + ($include_padding ? $this->padding : 0);

        return $d;
    }

    /**
     * @param $ymin
     * @param $ymax
     * @param $yscale
     * @return int
     */
    private function getYAxisHeight($ymin, $ymax, $yscale)
    {
        $axis_h = 0;

        $i = $this->getYAxisFirst($ymin, $ymax, $yscale);

        while ($i <= $ymax) {
            $box = $this->getTextBoundingBox($this->yaxis_font_size, 0, $this->getFont($this->yaxis_font), $i);
            $box_h = $box[1] - $box[5];
            if ($box_h > $axis_h) {
                $axis_h = $box_h;
            }

            $i += $this->getYAxisStep($ymin, $ymax, $yscale);
        }

        return $axis_h + 8;
    }

    /**
     * @param $ymin
     * @param $ymax
     * @param $yscale
     * @return int
     */
    private function getYAxisWidth($ymin, $ymax, $yscale)
    {
        $axis_w = 0;

        $i = $this->getYAxisFirst($ymin, $ymax, $yscale);

        while ($i <= $ymax) {
            $box = $this->getTextBoundingBox($this->yaxis_font_size, 0, $this->getFont($this->yaxis_font), $i);
            $box_w = $box[4] - $box[0];
            if ($box_w > $axis_w) {
                $axis_w = $box_w;
            }

            $i += $this->getYAxisStep($ymin, $ymax, $yscale);
        }

        return $axis_w + 8;
    }

    /**
     * @param $ymin
     * @param $ymax
     * @param $yscale
     * @return int
     */
    private function getXAxisHeight($ymin, $ymax, $yscale)
    {
        $axis_h = 0;

        $column_count = count($this->columns);

        for ($i = 0; $i < $column_count; $i++) {
            $box = $this->getTextAxisBoundingBox($this->xaxis_font_size, $this->xaxis_font_angle, $this->getFont($this->xaxis_font), $this->columns[$i]);

            $box_h = $box[3] - $box[1];
            if ($box_h > $axis_h) {
                $axis_h = $box_h;
            }
        }

        return $axis_h + 3;
    }

    /**
     * @param $ymin
     * @param $ymax
     * @param $yscale
     * @return int
     */
    private function getXAxisWidth($ymin, $ymax, $yscale)
    {
        $axis_w = 0;

        $column_count = count($this->columns);

        for ($i = 0; $i < $column_count; $i++) {
            $box = $this->getTextAxisBoundingBox($this->xaxis_font_size, $this->xaxis_font_angle, $this->getFont($this->xaxis_font), $this->columns[$i]);

            $box_w = $box[2] - $box[0];
            if ($box_w > $axis_w) {
                $axis_w = $box_w;
            }
        }

        return $axis_w + 3;
    }

    /**
     * @param $ymin
     * @param $ymax
     * @param $yscale
     * @param $axis_size
     * @param $chart_bounds
     * @return array
     */
    private function getAxisSizes($ymin, $ymax, $yscale, $axis_size, $chart_bounds)
    {
        $axis_size[0] = $this->getAxisSize(0, $ymin, $ymax, $yscale, $axis_size, $chart_bounds);
        $axis_size[1] = $this->getAxisSize(1, $ymin, $ymax, $yscale, $axis_size, $chart_bounds);
        $axis_size[2] = $this->getAxisSize(2, $ymin, $ymax, $yscale, $axis_size, $chart_bounds);
        $axis_size[3] = $this->getAxisSize(3, $ymin, $ymax, $yscale, $axis_size, $chart_bounds);

        return $axis_size;
    }

    /**
     * @param $ymin
     * @param $ymax
     * @param $yscale
     * @return int
     */
    private function getYAxisFirst($ymin, $ymax, $yscale)
    {
        $inc = $this->getYAxisStep($ymin, $ymax, $yscale);
        return intval($ymin / $inc) * $inc;
    }

    /**
     * @param $ymin
     * @param $ymax
     * @param $yscale
     * @return float|int
     */
    private function getYAxisStep($ymin, $ymax, $yscale)
    {
        $s = $yscale * 0.05;
        if ($s < 0.00001) {
            $s = 0.00001;
        }
        while (($ymax - $ymin) / $s > 100) {
            $s *= 10;
        }
        return $s;
    }

    /**
     * adjustYRange - Returns a new $ymin, $ymax and $yscale
     *
     * @param number $ymin
     * @param number $ymax
     * @param number $yscale
     * @param array $axis_size
     * @param array $chart_bounds
     *
     * @return array
     */
    private function adjustYRange($ymin, $ymax, $yscale, $axis_size, $chart_bounds)
    {
        if ($this->axis_data[0]['a'] == 'y' || $this->axis_data[2]['a'] == 'y') {
            //  Graph's Y Axis is vertical
            $chart_h = $chart_bounds[3] - $chart_bounds[1] - $axis_size[1] - $axis_size[3];
        }
        else {
            //  Graph's Y Axis is horizontal
            $chart_h = $chart_bounds[2] - $chart_bounds[0] - $axis_size[0] - $axis_size[2];
        }

        //  Go through each series working out the top Y-extent of any labels, adjusting ymax so that the labels fit in the graph

        for ($tries = 0; $tries < 5; $tries++) {
            $value_top_y = 0;
            $value_top_value = 0;
            $value_top_boxh = 0;
            $value_top_bary = 0;
            $value_top_series = false;
            $value_top_column = false;

            foreach ($this->data as $series_index => $series) {
                $font = $this->getFont($series['value_font']);

                if ($font !== false && $series['value_pos'] == 1) {
                    foreach ($this->columns as $column) {
                        if (isset($series['data']) && isset($series['data'][$column])) {
                            $value = $series['data'][$column];
                        }
                        else {
                            $value = 0;
                        }

                        if ($value >= 0) {
                            //  TODO: Labels differently for positive and negative bars
                        }
                        else {
                        }

                        list($a, $b) = $this->getBarYExtent($series_index, $column);

                        $bb = $b * $chart_h / $ymax;

                        $box = $this->getTextAxisBoundingBox($series['value_size'], $series['value_angle'], $font, $series['data'][$column]);
                        $box_h = $box[3] - $box[1] + 4;

                        if ($bb + $box_h > $value_top_y) {
                            $value_top_y = $bb + $box_h;
                            $value_top_boxh = $box_h;
                            $value_top_value = $b;
                            $value_top_bary = $bb;
                            $value_top_series = $series_index;
                            $value_top_column = $column;
                        }
                    }
                }
            }

            if ($value_top_series === false) {
                break;
            }
            if ($value_top_y <= $chart_h - 8) {
                break;
            }

            //  Adjust ymax

            $ymax = $value_top_value * $chart_h / ($chart_h - 8 - $value_top_boxh);
        }

        for ($yscale = 0.001; $yscale < $ymax; $yscale *= 10) {
        }

        return array($ymin, $ymax, $yscale);
    }

    /**
     * @param $series
     * @param $column
     * @param bool $ignore_lines
     * @return array
     */
    private function getBarYExtent($series, $column, $ignore_lines = false)
    {
        $type = $this->data[$series]['type'];

        $max = $this->data[$series]['data'][$column];

        if ($series < 0) {
            return array(0, 0);
        }

        if ($type == 'bar' || ($series == 0 && $type == 'stackedbar')) {
            $min = 0;
        }
        else if ($type == 'stackedbar') {
            list($temp, $min) = $this->getBarYExtent($series - 1, $column, true);
            $max += $min;
        }
        else if ($type == 'line') {
            if ($ignore_lines) {
                return $this->getBarYExtent($series - 1, $column, true);
            }
            $min = $max;
        }

        return array($min, $max);
    }

    /**
     * getHorizontalOrientation
     *
     * Returns false if the the graph is normal orientation (Y vertical)
     * Returns true if Y is horizontal
     *
     * @return bool
     */
    private function getHorizontalOrientation()
    {
        if ($this->axis_data[1]['a'] == 'y') {
            return true;
        }
        if ($this->axis_data[3]['a'] == 'y') {
            return true;
        }

        if ($this->axis_data[0]['a'] == 'x') {
            return true;
        }
        if ($this->axis_data[2]['a'] == 'x') {
            return true;
        }

        return false;
    }

    /**
     * getYMax
     * @return int
     */
    private function getYMax()
    {
        return $this->getYExtent(1);
    }

    /**
     * getYMin
     * @return int
     */
    private function getYMin()
    {
        return $this->getYExtent(-1);
    }

    /**
     * getYExtent
     *
     * This gets the maximum extent of all the bars and lines, either in a positive
     * or negative direction, depending on the sign of $dir
     * It takes into account bars stacked going in the specified direction
     *
     * @param int $dir
     * @return int
     */
    private function getYExtent($dir)
    {
        //  $dir is -1 to find the lowest Y value

        $dir = $dir < 0 ? -1 : 1;

        $column_height = array();
        foreach ($this->columns as $column) {
            $column_height[$column] = 0;
        }

        $num_stacks = 0; //  Number of separate stacks of bars

        $extent = 0; //  Maximum Y extent of any bars, stacked bars and lines.

        foreach ($this->data as $series) {
            $type = $series['type'];
            $data = $series['data'];

            if ($type == 'bar') {
                //  Reset column height totals to 0 because we are starting a new bar
                foreach ($this->columns as $column) {
                    $column_height[$column] = 0;
                }
                $num_stacks++;
            }

            if ($type == 'bar' || $type == 'stackedbar') {
                if ($num_stacks < 1)
                    $num_stacks = 1;

                foreach ($this->columns as $column) {
                    //  Get the extent, depending on the direction, and do not allow < 0
                    $value = (isset($data[$column])?$data[$column]:0) * $dir;
                    if ($value < 0) {
                        $value = 0;
                    }

                    $column_height[$column] += $value;
                    if ($column_height[$column] > $extent) {
                        $extent = $column_height[$column];
                    }
                }
            }
            else {
                foreach ($this->columns as $column) {
                    //  Get the extent, depending on the direction, and do not allow < 0
                    $value = (isset($data[$column])?$data[$column]:0) * $dir;
                    if ($value < 0) {
                        $value = 0;
                    }

                    if ($value > $extent) {
                        $extent = $value;
                    }
                }
            }
        }

        return $extent * $dir;
    }

    /**
     * @return int
     */
    private function getNumStacks()
    {
        $num_stacks = 0; //  Number of separate stacks of bars

        foreach ($this->data as $series) {
            $type = $series['type'];
            $data = $series['data'];

            if ($type == 'bar') {
                $num_stacks++;
            }

            if ($type == 'bar' || $type == 'stackedbar') {
                if ($num_stacks < 1) {
                    $num_stacks = 1;
                }
            }
        }

        return $num_stacks;
    }

    /**
     * @param $font
     * @return bool|string
     */
    private function getFont($font)
    {
        if ($font === false) {
            return false;
        }
        if ($font == '') {
            $font = $this->default_font;
        }
        if (strpos($font, '/') === false) {
            $font = dirname(__file__) . '/' . $font;
        }

        if (!file_exists($font)) {
            $this->error("Could not find font: '$font'");
        }

        return $font;
    }

    /**
     * @param $error
     */
    private function error($error)
    {
        echo '<h1>ChartLogix Error (BarChart)</h1><p>' . $error . '</p>';
        exit();
    }

    /**
     * getTextBoundingBox
     *
     * Provides a better answer than imagettfbox does for angled text
     * Calculates the bounding box of the text horizontally (which imagettfbox gets right) and then rotates the box
     *
     * @param int $size
     * @param float $angle
     * @param string $font
     * @param string $text
     *
     * @return array The points of non axis-aligned bounding rectangle
     */
    private function getTextBoundingBox($size, $angle, $font, $text)
    {
        //  This does it properly by getting the bounding box for horizontal text then rotating it

        if (!file_exists($font)) {
            $this->error("Could not find font '$font'");
        }

        $box = imagettfbbox($size, 0, $font, $text);

        $s = sin(-$angle * 3.1415926 / 180);
        $c = cos(-$angle * 3.1415926 / 180);

        return array
        (
            $c * $box[0] - $s * $box[1],
            $s * $box[0] + $c * $box[1],
            $c * $box[2] - $s * $box[3],
            $s * $box[2] + $c * $box[3],
            $c * $box[4] - $s * $box[5],
            $s * $box[4] + $c * $box[5],
            $c * $box[6] - $s * $box[7],
            $s * $box[6] + $c * $box[7],
        );
    }

    /**
     * getTextAxisBoundingBox
     *
     * Returns the axis-aligned rectangle completely containing the text
     * Return value is list( x1, y1, x2, y2, w, h )
     *
     * @param $size
     * @param $angle
     * @param $font
     * @param $text
     * @return array
     */
    private function getTextAxisBoundingBox($size, $angle, $font, $text)
    {
        if (is_array($text)) {
            $x1 = $y1 = $x2 = $y2 = 0;

            foreach ($text as $item) {
                $box = $this->getTextAxisBoundingBox($size, $angle, $font, $item);
                if ($box[4] > $x2 - $x1) {
                    $x1 = $box[0];
                    $x2 = $box[2];
                }
                if ($box[5] > $y2 - $y1) {
                    $y1 = $box[1];
                    $y2 = $box[3];
                }
            }
        }
        else {
            $box = $this->getTextBoundingBox($size, $angle, $font, $text);

            $x1 = $box[0];
            if ($x1 > $box[2]) {
                $x1 = $box[2];
            }
            if ($x1 > $box[4]) {
                $x1 = $box[4];
            }
            if ($x1 > $box[6]) {
                $x1 = $box[6];
            }
            $x2 = $box[0];
            if ($x2 < $box[2]) {
                $x2 = $box[2];
            }
            if ($x2 < $box[4]) {
                $x2 = $box[4];
            }
            if ($x2 < $box[6]) {
                $x2 = $box[6];
            }

            $y1 = $box[1];
            if ($y1 > $box[3]) {
                $y1 = $box[3];
            }
            if ($y1 > $box[5]) {
                $y1 = $box[5];
            }
            if ($y1 > $box[7]) {
                $y1 = $box[7];
            }
            $y2 = $box[1];
            if ($y2 < $box[3]) {
                $y2 = $box[3];
            }
            if ($y2 < $box[5]) {
                $y2 = $box[5];
            }
            if ($y2 < $box[7]) {
                $y2 = $box[7];
            }
        }

        return array($x1, $y1, $x2, $y2, $x2 - $x1, $y2 - $y1);
    }

    /**
     * @param $c1
     * @param $c2
     * @param $f
     * @return int
     */
    private function colourBlend($c1, $c2, $f) //  filter = 0.0 for source, 1.0 for dest
    {
        if ($f < 0) {
            $f = 0;
        }
        if ($f > 1) {
            $f = 1;
        }

        $a1 = ($c1 >> 24) & 0xFF;
        $r1 = ($c1 >> 16) & 0xFF;
        $g1 = ($c1 >> 8) & 0xFF;
        $b1 = ($c1) & 0xFF;

        $a2 = ($c2 >> 24) & 0xFF;
        $r2 = ($c2 >> 16) & 0xFF;
        $g2 = ($c2 >> 8) & 0xFF;
        $b2 = ($c2) & 0xFF;

        $a = $a1 * (1 - $f) + $a2 * $f;
        $r = $r1 * (1 - $f) + $r2 * $f;
        $g = $g1 * (1 - $f) + $g2 * $f;
        $b = $b1 * (1 - $f) + $b2 * $f;

        return (intval($a) << 24) + (intval($r) << 16) + (intval($g) << 8) + (intval($b));
    }

    /**
     * @param $c1
     * @param $c2
     * @return int
     */
    private function colourAdd($c1, $c2)
    {
        $r1 = ($c1 >> 16) & 0xFF;
        $g1 = ($c1 >> 8) & 0xFF;
        $b1 = ($c1) & 0xFF;

        $r2 = ($c2 >> 16) & 0xFF;
        $g2 = ($c2 >> 8) & 0xFF;
        $b2 = ($c2) & 0xFF;

        $r = $r1 + $r2;
        $g = $g1 + $g2;
        $b = $b1 + $b2;

        if ($r > 255) {
            $r = 255;
        }
        if ($g > 255) {
            $g = 255;
        }
        if ($b > 255) {
            $b = 255;
        }

        return (intval($r) << 16) + (intval($g) << 8) + (intval($b));
    }

    /**
     * @param $c1
     * @param $c2
     * @return int
     */
    private function colourSub($c1, $c2)
    {
        $r1 = ($c1 >> 16) & 0xFF;
        $g1 = ($c1 >> 8) & 0xFF;
        $b1 = ($c1) & 0xFF;

        $r2 = ($c2 >> 16) & 0xFF;
        $g2 = ($c2 >> 8) & 0xFF;
        $b2 = ($c2) & 0xFF;

        $r = $r1 - $r2;
        $g = $g1 - $g2;
        $b = $b1 - $b2;

        if ($r < 0) {
            $r = 0;
        }
        if ($g < 0) {
            $g = 0;
        }
        if ($b < 0) {
            $b = 0;
        }

        return (intval($r) << 16) + (intval($g) << 8) + (intval($b));
    }

    /**
     * @param $im
     * @param $x
     * @param $y
     * @param $xalign
     * @param $yalign
     * @param $font
     * @param $size
     * @param $col
     * @param $text
     * @param int $angle
     * @param float $align_first_char
     */
    private function drawAlignedText($im, $x, $y, $xalign, $yalign, $font, $size, $col, $text, $angle = 0, $align_first_char = 0.0)
    {
        //  Get box of text

        list($x1a, $y1a, $x2a, $y2a) = $this->getTextAxisBoundingBox($size, $angle, $font, 'Ag');
        list($x1b, $y1b, $x2b, $y2b) = $this->getTextAxisBoundingBox($size, $angle, $font, $text);

        if ($align_first_char < 0) {
            $align_first_char = 0;
        }
        if ($align_first_char > 1) {
            $align_first_char = 1;
        }

        $x1 = $align_first_char * $x1a + (1 - $align_first_char) * $x1b;
        $y1 = $y1b;
        $x2 = $align_first_char * $x2a + (1 - $align_first_char) * $x2b;
        $y2 = $y2b;

        $xx = $x1 * (1 - $xalign) + $x2 * $xalign;
        $yy = $y1 * (1 - $yalign) + $y2 * $yalign;

        imagettftext($im, $size, $angle, 0.5 + $x - $xx, 0.5 + $y - $yy, $col, $font, $text);
    }

    /**
     * @param $font
     * @param $size
     * @return mixed
     */
    private function getTextLineHeight($font, $size)
    {
        $box = $this->getTextBoundingBox($size, 0, $font, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789,.');
        $boxh = $box[1] - $box[5];

        return $boxh;
    }

    /**
     * getWrappedTextHeight - Returns the height of a block of text wrapped to the specified width
     *
     * @param string $font
     * @param int $size
     * @param int $w
     * @param string $text
     * @return int
     */
    private function getWrappedTextHeight($font, $size, $w, $text)
    {
        if ($text == '') {
            return 0;
        }

        $t = $this->getWrappedText($font, $size, $w, $text);

        $box = $this->getTextBoundingBox($size, 0, $font, join("\n", $t));
        $box_h = $box[1] - $box[5];

        $h = $box_h; //count( $t ) * $this->getTextLineHeight( $font, $size );

        return $h;
    }

    /**
     * @param $font
     * @param $size
     * @param $w
     * @param $text
     * @return array
     */
    private function getWrappedText($font, $size, $w, $text)
    {
        //  Break up sentence into words

        $words = array();
        $word = '';

        for ($i = 0; $i < strlen($text); $i++) {
            $c = $text[$i];
            $word .= $c;

            switch ($c) {
                case ' ';
                case ',';
                case '.';
                case ':';
                case ';';
                case '-';
                    if (trim($word) <> '')
                        $words[] = $word;
                    $word = '';
                    break;

                default:
                    break;
            }
        }

        if (trim($word) <> '') {
            $words[] = $word;
        }

        //  Take a word at a time, getting width until it wraps

        $lines = array();
        $line = '';

        $h = 0;

        for ($i = 0; $i < count($words); $i++) {
            if ($line == '') {
                $line = $words[$i];
            }
            else {
                $box = $this->getTextBoundingBox($size, 0, $font, $line . rtrim($words[$i]));
                $box_w = $box[2] - $box[0];

                if ($box_w > $w) {
                    $lines[] = rtrim($line);
                    $line = $words[$i];
                }
                else {
                    $line .= $words[$i];
                }
            }
        }

        if ($line != '') {
            $lines[] = rtrim($line);
        }

        //  Return array of lines

        return $lines;
    }

    /**
     * @param $im
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @param $col
     */
    private function drawLine($im, $x1, $y1, $x2, $y2, $col)
    {
        $dx = $x2 - $x1;
        $dy = $y2 - $y1;

        if (abs($dx) > abs($dy)) //  Horizontal is main axis
        {
            if ($x1 > $x2) {
                $t = $x1;
                $x1 = $x2;
                $x2 = $t;
                $t = $y1;
                $y1 = $y2;
                $y2 = $t;
            }

            for ($i = intval($x1); $i <= $x2; $i++) {
                $y = $y1 + ($y2 - $y1) * ($i - $x1) / ($x2 - $x1) - 0.5;
                $f = $y - intval($y);

                $f1 = ($f * 127);
                $f2 = 127 - ($f * 127);

                imagesetpixel($im, $i, intval($y), $col + ($f1 << 24));
                imagesetpixel($im, $i, intval($y) + 1, $col + ($f2 << 24));
            }
        }
        else //  Vertical is main axis
        {
            if ($y1 > $y2) {
                $t = $x1;
                $x1 = $x2;
                $x2 = $t;
                $t = $y1;
                $y1 = $y2;
                $y2 = $t;
            }

            for ($i = intval($y1); $i <= $y2; $i++) {
                $x = $x1 + ($x2 - $x1) * ($i - $y1) / ($y2 - $y1) - 0.5;
                $f = $x - intval($x);

                $f1 = ($f * 127);
                $f2 = 127 - ($f * 127);

                imagesetpixel($im, intval($x), $i, $col + ($f1 << 24));
                imagesetpixel($im, intval($x) + 1, $i, $col + ($f2 << 24));
            }
        }
    }

    /**
     * drawVShadedRectangle - Draws a rectange with a vertical gradient
     *
     * @param resource $im
     * @param float $x1
     * @param float $y1
     * @param float $x2
     * @param float $y2
     * @param string|int $col1
     * @param string|int $col2
     */
    private function drawVShadedRectangle($im, $x1, $y1, $x2, $y2, $col1, $col2)
    {
        if ($y2 < $y1) {
            $t = $y2;
            $y2 = $y1;
            $y1 = $t;
        }

        if ($y1 == $y2) {
            return;
        }

        for ($i = $y1; $i <= $y2; $i++) {
            imageline($im, $x1, $i, $x2, $i, $this->colourBlend($col1, $col2, ($i - $y1) / ($y2 - $y1)));
        }
    }

    /**
     * drawHShadedRectangle - Draws a rectange with a horizontal gradient
     *
     * @param resource $im
     * @param float $x1
     * @param float $y1
     * @param float $x2
     * @param float $y2
     * @param string|int $col1
     * @param string|int $col2
     */
    private function drawHShadedRectangle($im, $x1, $y1, $x2, $y2, $col1, $col2)
    {
        if ($x2 < $x1) {
            $t = $x2;
            $x2 = $x1;
            $x1 = $t;
        }

        if ($x1 == $x2) {
            return;
        }

        for ($i = $x1; $i <= $x2; $i++) {
            imageline($im, $i, $y1, $i, $y2, $this->colourBlend($col1, $col2, ($i - $x1) / ($x2 - $x1)));
        }
    }

    /**
     * drawThickLine - DRaws a line with thickness between the two specified points
     *
     * @param resource $im
     * @param float $x1
     * @param float $y1
     * @param float $x2
     * @param float $y2
     * @param float $thickness
     * @param string|int $col
     */
    private function drawThickLine($im, $x1, $y1, $x2, $y2, $thickness, $col)
    {
        $dx = $x2 - $x1;
        $dy = $y2 - $y1;

        $d = sqrt($dx * $dx + $dy * $dy);

        if ($d == 0)
            return;

        $dx /= $d;
        $dy /= $d;

        $t = $thickness * 0.5;

        $p = array();

        $p[] = array($x1 + $dy * $t, $y1 - $dx * $t);
        $p[] = array($x2 + $dy * $t, $y2 - $dx * $t);
        $p[] = array($x2 - $dy * $t, $y2 + $dx * $t);
        $p[] = array($x1 - $dy * $t, $y1 + $dx * $t);

        $this->drawShadedConvexPolygon($im, $p, $col);
    }

    /**
     * drawShadedConvexPolygon - $p is an array of points in the format ( (x1, y1), (x2, y2), ... )
     *
     * @param resource $im
     * @param array $p
     * @param string|int $col
     * @return mixed
     */
    private function drawShadedConvexPolygon($im, $p, $col)
    {
        $n = count($p);

        if ($n == 0) {
            return;
        }

        //  Find bounding box

        $bx1 = $bx2 = $p[0][0];
        $by1 = $by2 = $p[0][1];

        for ($i = 1; $i < $n; $i++) {
            if ($bx1 > $p[$i][0]) {
                $bx1 = $p[$i][0];
            }
            if ($bx2 < $p[$i][0]) {
                $bx2 = $p[$i][0];
            }

            if ($by1 > $p[$i][1]) {
                $by1 = $p[$i][1];
            }
            if ($by2 < $p[$i][1]) {
                $by2 = $p[$i][1];
            }
        }

        $p[] = $p[0]; //  Same point on end as start

        for ($y = intval($by1); $y < $by2; $y++) {
            //  Calculate the x start and end for 10 subdivisions of the scanline

            $lines = array();

            $x1min = $bx2;
            $x1max = $bx1;
            $x2min = $bx2;
            $x2max = $bx1;

            $blank = false; //  Whether there are any blank scanlines

            for ($yd = 0; $yd < 10; $yd++) {
                $yy = $y + 0.1 * $yd + 0.05;

                if ($yy > $by1 && $yy < $by2) {
                    //  Find min and max for this scanline

                    $x1 = $bx2;
                    $x2 = $bx1;

                    for ($i = 0; $i < $n; $i++) {
                        if ($yy >= $p[$i][1] && $yy < $p[$i + 1][1]) {
                            $x = $p[$i][0] + ($p[$i + 1][0] - $p[$i][0]) * ($yy - $p[$i][1]) / ($p[$i + 1][1] - $p[$i][1]);
                            if ($x2 < $x) {
                                $x2 = $x;
                            }
                        }
                        else if ($yy >= $p[$i + 1][1] && $yy < $p[$i][1]) {
                            $x = $p[$i][0] + ($p[$i + 1][0] - $p[$i][0]) * ($yy - $p[$i][1]) / ($p[$i + 1][1] - $p[$i][1]);
                            if ($x1 > $x) {
                                $x1 = $x;
                            }
                        }
                    }

                    if ($x2 > $x1) {
                        if ($x1 < $x1min) {
                            $x1min = $x1;
                        }
                        if ($x1 > $x1max) {
                            $x1max = $x1;
                        }
                        if ($x2 < $x2min) {
                            $x2min = $x2;
                        }
                        if ($x2 > $x2max) {
                            $x2max = $x2;
                        }

                        $lines[$yd] = array($x1, $x2);
                    }
                    else {
                        $lines[$yd] = false;
                        $blank = true;
                    }
                }
                else {
                    $lines[$yd] = false;
                    $blank = true;
                }
            }

            //- Now use this information to render pixels and subpixels

            if ($x1min < $x2max) //  There is a line at all
            {
                //- The two antialiased portions do not meet in the same pixel

                if (intval($x1max) < intval($x2min) - 1 && !$blank) {
                    //- Loop for left-hand antialiasing

                    for ($i = intval($x1min); $i <= $x1max; $i++) {
                        $f = 0;

                        for ($j = 0; $j < 10; $j++) {
                            if ($lines[$j][0] <= $i) {
                                $f += 0.1;
                            }
                            else if ($lines[$j][0] < $i + 1) {
                                $f += 0.1 - 0.1 * ($lines[$j][0] - $i);
                            }
                        }

                        $f = 127 - intval((127.0 * $f));

                        imagesetpixel($im, $i, $y, $col + ($f << 24));
                    }

                    //- Draw solid middle portion

                    imageline($im, $i, $y, intval($x2min) - 1, $y, $col);

                    //- Loop for right-hand antialiasing

                    for ($i = intval($x2min); $i <= $x2max; $i++) {
                        $f = 0;

                        for ($j = 0; $j < 10; $j++) {
                            if ($lines[$j][1] >= $i + 1) {
                                $f += 0.1;
                            }
                            else if ($lines[$j][1] > $i) {
                                $f += 0.1 * ($lines[$j][1] - $i);
                            }
                        }

                        $f = 127 - intval(127.0 * $f);
                        imagesetpixel($im, $i, $y, $col + ($f << 24));
                    }
                }

                //- Antialiased all the way along this scanline

                else {
                    for ($i = intval($x1min); $i <= $x2max; $i++) {
                        $f = 0;

                        for ($j = 0; $j < 10; $j++) {
                            if ($lines[$j]) {
                                $x1 = $lines[$j][0];
                                $x2 = $lines[$j][1];

                                if ($x1 < $i)
                                    $x1 = $i;
                                if ($x2 > $i + 1)
                                    $x2 = $i + 1;

                                if ($x1 < $x2)
                                    $f += 0.1 * ($x2 - $x1);
                            }
                        }

                        $f = 127 - intval(127.0 * $f);
                        imagesetpixel($im, $i, $y, $col + ($f << 24));
                    }
                }
            }
        }
    }

    /**
     * @param $im
     * @param $cx
     * @param $cy
     * @param $rx
     * @param $ry
     * @param $col1
     * @param bool $col2
     * @return mixed
     */
    private function drawShadedElipse($im, $cx, $cy, $rx, $ry, $col1, $col2 = false)
    {
        if ($col2 === false) {
            $col2 = $col1;
        }

        $y1 = $cy - $ry;
        $y2 = $cy + $ry;

        if ($y2 <= $y1) {
            return;
        }

        for ($y = intval($y1); $y < $y2; $y++) {
            $col = $this->colourBlend($col1, $col2, ($y - $y1) / ($y2 - $y1));

            //  Calculate the x start and end for 10 subdivisions of the scanline

            $lines = array();

            $x1min = $cx + $rx;
            $x1max = $cx - $rx;
            $x2min = $cx + $rx;
            $x2max = $cx - $rx;

            $blank = false; //  Whether there are any blank scanlines

            for ($yd = 0; $yd < 10; $yd++) {
                $yy = $y + 0.1 * $yd + 0.05;

                $yu = ($yy - $cy) / $ry;

                if ($yu > -1.0 && $yu < 1.0) {
                    $xu = sqrt(1.0 - $yu * $yu);

                    $x1 = $cx - $rx * $xu;
                    $x2 = $cx + $rx * $xu;

                    if ($x1 < $x1min)
                        $x1min = $x1;
                    if ($x1 > $x1max)
                        $x1max = $x1;
                    if ($x2 < $x2min)
                        $x2min = $x2;
                    if ($x2 > $x2max)
                        $x2max = $x2;

                    $lines[$yd] = array($x1, $x2);
                }
                else {
                    $lines[$yd] = false;
                    $blank = true;
                }
            }

            //- Now use this information to render pixels and subpixels

            if ($x1min < $x2max) //  There is a line at all
            {
                //- The two antialiased portions do not meet in the same pixel

                if (intval($x1max) < intval($x2min) && !$blank) {
                    //- Loop for left-hand antialiasing

                    for ($i = intval($x1min); $i <= $x1max; $i++) {
                        $f = 0;

                        for ($j = 0; $j < 10; $j++) {
                            if ($lines[$j][0] <= $i) {
                                $f += 0.1;
                            }
                            else if ($lines[$j][0] < $i + 1) {
                                $f += 0.1 - 0.1 * ($lines[$j][0] - $i);
                            }
                        }

                        $f = 127 - intval((127.0 * $f));

                        imagesetpixel($im, $i, $y, $col + ($f << 24));
                    }

                    //- Draw solid middle portion

                    imageline($im, $i, $y, intval($x2min) - 1, $y, $col);

                    //- Loop for right-hand antialiasing

                    for ($i = intval($x2min); $i <= $x2max; $i++) {
                        $f = 0;

                        for ($j = 0; $j < 10; $j++) {
                            if ($lines[$j][1] >= $i + 1) {
                                $f += 0.1;
                            }
                            else if ($lines[$j][1] > $i) {
                                $f += 0.1 * ($lines[$j][1] - $i);
                            }
                        }

                        $f = 127 - intval(127.0 * $f);
                        imagesetpixel($im, $i, $y, $col + ($f << 24));
                    }
                }

                //- Antialiased all the way along this scanline

                else {
                    for ($i = intval($x1min); $i <= $x2max; $i++) {
                        $f = 0;

                        for ($j = 0; $j < 10; $j++) {
                            if ($lines[$j]) {
                                $x1 = $lines[$j][0];
                                $x2 = $lines[$j][1];

                                if ($x1 < $i)
                                    $x1 = $i;
                                if ($x2 > $i + 1)
                                    $x2 = $i + 1;

                                if ($x1 < $x2)
                                    $f += 0.1 * ($x2 - $x1);
                            }
                        }

                        $f = 127 - intval(127.0 * $f);
                        imagesetpixel($im, $i, $y, $col + ($f << 24));
                    }
                }
            }
        }
    }

    /**
     * hexcol - Interprets an HTML hexadecimal colour from an int or a string
     *
     * @param string|int $t
     * @return int|string
     */
    private function hexcol($t)
    {
        if (is_integer($t)) {
            return $t;
        }
        else if (is_string($t)) {
            if ($t[0] == '#') {
                $t = substr($t, 1);
            }
            $t = strtoupper($t);

            $h = "0123456789ABCDEF";
            $c = 0;

            for ($i = 0; $i < strlen($t); $i++) {
                $c <<= 4;

                $p = strpos($h, $t[$i]);
                if ($p !== false) {
                    $c += $p;
                }
            }

            return $c;
        }
        else {
            return 0xFF00FF;
        }
    }

    /**
     * convertToThumbnail - Renders a thumbnail of an image
     * @param resource $im
     * @param int $thumb_w
     * @param int $thumb_h
     * @return resource
     */
    private function convertToThumbnail( $im, $thumb_w=0, $thumb_h=0 )
    {
        if( $thumb_w <= 0 && $thumb_h <= 0 ) return $im;

        $w = imagesx( $im );
        $h = imagesy( $im );

        if( $thumb_w == 0 )
        {
            $thumb_w = $w * $thumb_h / $h;
        }
        else if( $thumb_h == 0 )
        {
            $thumb_h = $h * $thumb_w / $w;
        }

        $im2 = imagecreatetruecolor( $thumb_w, $thumb_h );
        imagecopyresampled( $im2, $im, 0, 0, 0, 0, $thumb_w, $thumb_h, $w, $h );
        imagedestroy( $im );

        return $im2;
    }


}



/**
 * PieChart - ChartLogix Pie Chart class - self contained bar chart renderer using GD
 *
 * @example There is an overview at            Documentation/php_pie_chart.html
 * @example Function reference at              Documentation/pie_chart-function_reference.html
 * @example Lots of examples with source code  Documentation/pie_chart-examples.html
 */
class PieChart
{

    //---- DATA

    //- Width and height of output image

    /**
     * @var int
     */
    private $w = 0;
    /**
     * @var int
     */
    private $h = 0;

    //- Settings

    /**
     * @var string
     */
    private $default_font = 'arial.ttf';

    /**
     * @var int
     */
    private $bg1 = 0xEEEEEE;
    /**
     * @var int
     */
    private $bg2 = 0xEEEEEE;

    /**
     * @var int
     */
    private $padding = 20;

    /**
     * @var string
     */
    private $title_font = '';
    /**
     * @var int
     */
    private $title_font_size = 15;
    /**
     * @var int
     */
    private $title_col = 0x000000;

    /**
     * @var int
     */
    private $title_xpos = 0;
    /**
     * @var int
     */
    private $title_ypos = 0;

    /**
     * @var int
     */
    private $legend_width = 40;

    /**
     * @var string
     */
    private $legend_font = '';
    /**
     * @var int
     */
    private $legend_font_size = 10;
    /**
     * @var int
     */
    private $legend_font_col = 0x000000;

    /**
     * @var int
     */
    private $legend_between_padding = 10;

    /**
     * @var int
     */
    private $legend_bg = 0xFFFFFF;
    /**
     * @var int
     */
    private $legend_border = 0x000000;
    /**
     * @var int
     */
    private $legend_box_padding = 10;

    /**
     * @var int
     */
    private $legend_key_size = 10;
    /**
     * @var int
     */
    private $legend_key_padding = 10;

    /**
     * @var int
     */
    private $legend_xpos = 1;
    /**
     * @var int
     */
    private $legend_ypos = 0;

    /**
     * @var int
     */
    private $edge3d_size = 0;
    /**
     * @var int
     */
    private $edge3d_hardness = 0;
    /**
     * @var bool
     */
    private $edge3d_reverse = false;

    /**
     * @var int
     */
    private $hole_size = 0;

    //- The pie data

    /**
     * @var array
     */
    private $data = array();
    /**
     * @var int
     */
    private $total = 0; //  Total of all the data values, for calculating the %

    /**
     * @var string
     */
    private $title = '';



    function __construct()
    {
    }

    /**
     * setTitle - Sets the title to display in the image.
     *
     * @param string $title The title to display. If it is too long for one line it will be split onto multiple lines.
     */
    function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * addData - Adds a data item to the pie chart
     *
     * @param $name
     * @param $value
     * @param $colour
     * @return mixed
     */
    function addData($name, $value, $colour)
    {
        $value *= 1.0; //  Make sure it's a number

        if ($value < 0) {
            return;
        }

        $this->data[] = array
        (
            'name' => $name,
            'value' => $value,
            'colour' => $this->hexcol($colour),
        );

        $this->total += $value;
    }

    /**
     * setDefaultFont - Sets the default font which will be used for the title, legend and any other text,
     * if you do not explicitly specify fonts for them. ChartLogix will look in the same directory as chartlogix.inc.php
     * if you specify a font name without a path.
     *
     * @param string $font Font to use as the default
     */
    function setDefaultFont($font)
    {
        $this->default_font = $font;
    }

    /**
     * setBackground - Sets the background colour of the image, allowing you to create a vertical gradient by specifying a top and bottom colour.
     * Colours are specified as hexadecimal HTML colours, either as a string or an integer
     *
     * @example $chart->setBackground( '99CCFF' );  //  Sets the background to light blue.
     * @example $chart->setBackground( 0x99CCFF );  //  Sets the background to light blue using an integer hexadecimal number.
     * @example $chart->setBackground( 'DDDDDD', '999999' );  //  Sets the background to a gradient from light grey to slightly darker grey.
     *
     * @param string|int $c1 Colour of background at the top of the image
     * @param string|int $c2 Colour of background at the bottom of the image. If not specified, the background is the solid colour specified by $c1.
     */
    function setBackground($c1 = 0xEEEEEE, $c2 = false)
    {
        if ($c2 === false) {
            $c2 = $c1;
        }
        $this->bg1 = $this->hexcol($c1);
        $this->bg2 = $this->hexcol($c2);
    }

    /**
     * setPadding - Controls the spacing between the elements of the image - the pie chart, the title and the legend,
     * and also the distance between these elements and the edge of the image.
     *
     * @param int $padding Size of the padding in pixels.
     */
    function setPadding($padding = 20)
    {
        $padding = intval($padding);
        if ($padding < 0) {
            $padding = 0;
        }
        $this->padding = $padding;
    }

    /**
     * setTitleStyle - Sets the font, size and colour of the title of the graph
     *
     * @example $chart->setTitleStyle( "Verdana", 20, '000066' );  //  Sets the title style to Verdana, size 20, dark blue.
     *
     * @param string $font (Optional; default Arial) Name of the font to use.
     * @param int $size (Optional; default 15) Size of the font in points
     * @param string|int $col (Optional; default 000000) Colour of the title, specified as a hexadecimal HTML colour.
     */
    function setTitleStyle($font = '', $size = 15, $col = 0x000000)
    {
        $size = intval($size);
        if ($size < 0) {
            $size = 0;
        }

        $this->title_font = $font;
        $this->title_font_size = $size;
        $this->title_col = $this->hexcol($col);
    }

    /**
     * setTitlePosition - Sets the position and alignment of the title
     *
     * @param int $xpos Horizontal alignment of the title, -1 = Left aligned, 0 = Centred, 1 = Right aligned
     * @param int $ypos Vertical position, 0 = Top, 1 = Bottom
     */
    function setTitlePosition($xpos = 0, $ypos = 0)
    {
        $this->title_xpos = $xpos;
        $this->title_ypos = $ypos;
    }

    /**
     * setLegendWidth
     * Setting the legend width to 0 will hide the legend.
     *
     * @example $chart->setLegendWidth( 50 );  //  Sets the legend to be 50% of the width of the image.
     *
     * @param int $width Percentage of the width of the image taken up by the legend.
     */
    function setLegendWidth($width = 40)
    {
        $width *= 1.0;
        if ($width < 0) {
            $width = 0;
        }
        if ($width > 100) {
            $width = 100;
        }
        $this->legend_width = $width;
    }

    /**
     * setLegendTextStyle - Sets the style of the text in the legend.
     *
     * @example $chart->setLegendTextStyle( "Verdana", 8, '663300', 10 );
     *
     * @param string (Optional; default Arial) $font Font to use in the legend text.
     * @param int $size (Optional; default 10) Size of text in points.
     * @param int $col (Optional; default 000000) Colour of the text, specified as a hexadecimal HTML colour.
     * @param int $between (Optional; default 10) Spacing between items in the legend.
     */
    function setLegendTextStyle($font = '', $size = 10, $col = 0x000000, $between = 10)
    {
        $this->legend_font = $font;
        $this->legend_font_size = $size;
        $this->legend_font_col = $this->hexcol($col);

        $this->legend_between_padding = $between;
    }

    /**
     * setLegendBoxStyle - Sets the colours and the spacing for the legend box
     *
     * @example $chart->setLegendBoxStyle( 'FFFFCC', '333333', 20 );  //  Gives the legend box a light yellow background, dark grey border, and 20 pixels of padding.
     *
     * @param string|int $bg (Optional; default FFFFFF) The colour of the background of the legend
     * @param string|int $border (Optional; default 000000) The border colour of the legend
     * @param int $padding (Optional; default 10) The padding inside the legend box and between the legend items
     */
    function setLegendBoxStyle($bg = 0xFFFFFF, $border = 0x000000, $padding = 10)
    {
        $this->legend_bg = $this->hexcol($bg);
        $this->legend_border = $this->hexcol($border);
        $this->legend_box_padding = $padding;
    }

    /**
     * setLegendKeyStyle - Sets the style of the boxes next to the items in the legend.
     *
     * @param int $size (Optional; default 10) Size of the coloured squares.
     * @param int $padding (Optional; default 10) Horizontal distance between the coloured squares and the text next to them.
     */
    function setLegendKeyStyle($size = 10, $padding = 10)
    {
        $padding = intval($padding);
        if ($padding < 0) {
            $padding = 0;
        }

        $this->legend_key_size = $size;
        $this->legend_key_padding = $padding;
    }

    /**
     * setLegendPosition - Sets the position of the legend.
     *
     * @example $chart->setLegendPosition( 0, 0 );  //  Sets the legend to be in the top left corner of the image.
     *
     * @param int $xpos Horizontal position of legend: 0 = Left, 1 = Right
     * @param int $ypos Vertical alignment of the title: -1 = Top, 0 = Middle, 1 = Bottom
     */
    function setLegendPosition($xpos = 1, $ypos = 0)
    {
        $xpos = intval($xpos);
        if ($xpos < 0) {
            $xpos = -1;
        }
        if ($xpos > 0) {
            $xpos = 1;
        }

        $ypos = intval($ypos);
        if ($ypos < 0) {
            $ypos = -1;
        }
        if ($ypos > 0) {
            $ypos = 1;
        }

        $this->legend_xpos = $xpos;
        $this->legend_ypos = $ypos;
    }

    /**
     * set3DEdgeStyle - Gives the pie chart a 3D edge effect.
     * Specifying a hardness value but keeping a size of 0 will put a gradient on the pie chart without the 3D edge.
     *
     * @param float $size The size of the 3D edge, as a proportion of the radius of the pie chart (eg. 0.1 is 10%)
     * @param float $hardness How visible the 3D effect is - from 0.0 (invisible) to 1.0 (very visible)
     * @param bool $reverse Reverses the light and dark parts of the shading
     */
    function set3DEdgeStyle($size, $hardness, $reverse = false)
    {
        $size = intval($size);
        if ($size < 0) {
            $size = 0;
        }
        if ($size > 100) {
            $size = 100;
        }

        $hardness = intval($hardness);
        if ($hardness < 0) {
            $hardness = 0;
        }
        if ($hardness > 100) {
            $hardness = 100;
        }

        $this->edge3d_size = $size;
        $this->edge3d_hardness = $hardness;
        $this->edge3d_reverse = $reverse ? true : false;
    }

    /**
     * setHoleSize - Sets the size of the hole in the pie chart.
     *
     * @param float $size The size of the hole, as a proportion of the radius of the pie chart (eg. 0.1 is 10%)
     */
    function setHoleSize($size)
    {
        $size = intval($size);
        if ($size < 0) {
            $size = 0;
        }
        if ($size > 100) {
            $size = 100;
        }

        $this->hole_size = $size;
    }

    /**
     * drawPNG - Outputs a PNG image to the web browser, including the Content-type header.
     *
     * This has the capability to create thumbnails of graphs - rendered at high res and then
     * resized down to a thumbnail size
     *
     * @example $chart->drawPNG( 500, 400 );  //  Draws a chart at 500x400 pixels, then sends it to the web browser as a PNG image.
     * @example $chart->drawPNG( 500, 400, 0, 100 );  //  Draws a chart at 500x400 pixels, then scales the image down to 100 pixels high before sending to the web browser.
     *
     * @param int $w Width of the image in pixels.
     * @param int $h Height of the image in pixels.
     * @param int $thumb_w (Optional) If you want to generate a thumbnail image sepcify either the width or the height
     * @param int $thumb_h (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     */
    function drawPNG($w, $h, $thumb_w = 0, $thumb_h = 0)
    {
        $im = $this->drawIm($w, $h);
        $im = $this->convertToThumbnail($im, $thumb_w, $thumb_h);

        //- Output PNG data

        header('Content-type: image/png');
        imagepng($im);

        imagedestroy($im);
    }

    /**
     * savePNG - Saves the chart as a PNG file.
     * The filename can be specified with an absolute path, or with a relative path, which is relative to the script which is being requested by the Web browser.
     *
     * @example $chart->savePNG( 'chart1.png', 500, 400 );  //  Saves the chart as chart1.png in the same directory as the PHP script which is being executed.
     *
     * @param string $filename Name of the file.
     * @param int $w Width of the image in pixels.
     * @param int $h Height of the image in pixels.
     * @param int $thumb_w (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     * @param int $thumb_h (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     */
    function savePNG($filename, $w, $h, $thumb_w = 0, $thumb_h = 0)
    {
        $im = $this->drawIm($w, $h);
        $im = $this->convertToThumbnail($im, $thumb_w, $thumb_h);

        //- Save PNG data

        imagepng($im, $filename);

        imagedestroy($im);
    }

    /**
     * drawJPEG - Outputs a JPEG image to the web browser, including the Content-type header.
     *
     * This has the capability to create thumbnails of graphs - rendered at high res and then
     * resized down to a thumbnail size
     *
     * @example $chart->drawJPEG( 500, 400, 90 );  //  Output a 90 pixel wide thumbnail of this chart
     *
     * @param int $w Width of the image in pixels.
     * @param int $h Height of the image in pixels.
     * @param int $quality (Optional; default 75) JPEG Quality - from 0 (lowest quality, small file) to 100 (best quality, large file)
     * @param int $thumb_w (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     * @param int $thumb_h (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     */
    function drawJPEG($w, $h, $quality = 75, $thumb_w = 0, $thumb_h = 0)
    {
        $im = $this->drawIm($w, $h);
        $im = $this->convertToThumbnail($im, $thumb_w, $thumb_h);

        //- Output JPEG data

        header('Content-type: image/jpeg');
        imagejpeg($im, NULL, $quality);

        imagedestroy($im);
    }

    /**
     * saveJPEG - Saves the chart as a JPEG file.
     * The filename can be specified with an absolute path, or with a relative path, which is relative to the script which is being requested by the Web browser.
     *
     * @example $chart->saveJPEG( 'images/charts/chart1.jpg', 500, 400 );  //  Saves the chart as chart1.jpg in the images/charts directory, relative to the PHP script which is being executed.
     *
     * @param string $filename Name of the file.
     * @param int $w Width of the image in pixels.
     * @param int $h Height of the image in pixels.
     * @param int $quality (Optional; default 75) JPEG Quality - from 0 (lowest quality, small file) to 100 (best quality, large file)
     * @param int $thumb_w (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     * @param int $thumb_h (Optional) If you want to generate a thumbnail image sepcify either the width or the height.
     */
    function saveJPEG($filename, $w, $h, $quality = 75, $thumb_w = 0, $thumb_h = 0)
    {
        $im = $this->drawIm($w, $h);
        $im = $this->convertToThumbnail($im, $thumb_w, $thumb_h);

        //- Save JPEG data

        imagejpeg($im, $filename, $quality);

        imagedestroy($im);
    }

    /**
     * drawIm - Internal function to render a chart
     *
     * @param int $w
     * @param int $h
     * @return resource The GD image of the rendered chart
     */
    private function drawIm($w, $h)
    {
        //- Pie chart parameters

        $legend_width = $this->legend_width * 0.01;

        $legend_valign = $this->legend_ypos; //  -1 = top, 0 = middle, 1 = bottom
        $legend_pos = $this->legend_xpos; //  0=left, 1=right

        $padding = $this->padding;

        $legend_bg = $this->legend_bg;
        $legend_border = $this->legend_border;
        $legend_box_padding = $this->legend_box_padding;
        $legend_between_padding = $this->legend_between_padding;
        $legend_key_padding = $this->legend_key_padding;
        $legend_key_size = $this->legend_key_size;

        $legend_font = $this->getFont($this->legend_font);
        $legend_font_size = $this->legend_font_size;
        $legend_font_col = $this->legend_font_col;

        $title_pos = $this->title_ypos; //  0=top, 1=bottom
        $title_halign = $this->title_xpos; //  -1=left, 0=middle, 1=right

        $title_font = $this->getFont($this->title_font);
        $title_font_size = $this->title_font_size;
        $title_col = $this->title_col;

        $hole_size = $this->hole_size * 0.01;

        $edge3d_size = $this->edge3d_size * 0.01 * (1 - $hole_size);
        $edge3d_hardness = intval(0x50 * $this->edge3d_hardness * 0.01);

        if ($hole_size > 0) {
            $edge3d_size *= 0.5;
        }

        if ($this->edge3d_reverse) {
            $edge3d_hardness *= -1;
        }

        //- Set up image

        $im = imagecreatetruecolor($w, $h);
        imagealphablending($im, true);
        if (function_exists('imageantialias')) {
            imageantialias($im, false);
        }

        //- Draw background

        for ($i = 0; $i < $h; $i++) {
            $c = $this->colourBlend($this->bg1, $this->bg2, $i / $h);
            imagefilledrectangle($im, 0, $i, $w - 1, $i, $c);
        }

        //- Draw title

        $title_h = 0;

        if ($this->title != '') {
            $title_lines = $this->getWrappedText($title_font, $title_font_size, $w - $padding * 2, $this->title);
            $title_box = $this->getTextBoundingBox($title_font_size, 0, $title_font, join("\n", $title_lines));

            $title_h = $title_box[1] - $title_box[5];

            $box = $this->getTextBoundingBox($title_font_size, 0, $title_font, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
            $top = -$box[5];
            $line_h = $box[1] - $box[5];

            $box = $this->getTextBoundingBox($title_font_size, 0, $title_font, "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz\nABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
            $line_spacing = $box[1] - $box[5] - $line_h * 2;

            if ($title_pos == 0) {
                $y = $padding + $top;
            }
            else {
                $y = $h - $padding - $title_h + $top;
            }

            if ($title_halign < 0) {
                imagettftext($im, $title_font_size, 0, $padding, $y, $title_col, $title_font, join("\n", $title_lines));
            }
            else if ($title_halign > 0) {
                foreach ($title_lines as $line) {
                    $box = $this->getTextBoundingBox($title_font_size, 0, $title_font, $line);
                    $box_w = $box[2] - $box[0];

                    $x = $w - $padding - $box_w;
                    imagettftext($im, $title_font_size, 0, $x, $y, $title_col, $title_font, $line);
                    $y += $box[1] - $box[5] + $line_spacing;
                }
            }
            else {
                foreach ($title_lines as $line) {
                    $box = $this->getTextBoundingBox($title_font_size, 0, $title_font, $line);
                    $box_w = $box[2] - $box[0];

                    $x = ($w - $box_w) * 0.5;
                    imagettftext($im, $title_font_size, 0, $x, $y, $title_col, $title_font, $line);
                    $y += $box[1] - $box[5] + $line_spacing;
                }
            }

            $title_h += $padding;
        }

        //- Draw pie

        $pie_y1 = intval($padding);
        $pie_y2 = intval($h - $padding);

        $pie_x1 = intval($padding);
        $pie_x2 = intval($w - $padding);

        if ($legend_width > 0) {
            if ($legend_pos == 0) {
                $pie_x1 = intval($w * ($legend_width) + $padding * 0.5);
            }
            else {
                $pie_x2 = intval($w * (1 - $legend_width) - $padding * 0.5);
            }
        }

        if ($title_pos == 0) {
            $pie_y1 += $title_h;
        }
        else {
            $pie_y2 -= $title_h;
        }

        $pie_w = $pie_x2 - $pie_x1;
        $pie_h = $pie_y2 - $pie_y1;

        $n = count($this->data);

        $cx = ($pie_x1 + $pie_x2) / 2;
        $cy = ($pie_y1 + $pie_y2) / 2;

        $rad = 0.5 * ($pie_w < $pie_h ? $pie_w : $pie_h);

        $edge3d_size *= $rad;

        //  Black outer line

        $this->drawShadedElipse($im, $cx, $cy, $rad + 1, $rad + 1, 0x000000);

        //  Portions of pie

        $a = 0;

        for ($i = 0; $i < $n; $i++) {
            if ($this->data[$i]['value'] > 0) {
                $aa = $a + $this->data[$i]['value'] / $this->total;
                $col = $this->data[$i]['colour'];

                $this->drawShadedPie($im, $cx, $cy, $rad, $rad, $a, $aa, $this->colourAdd($col, $edge3d_hardness * 0x010101), $this->colourSub($col, $edge3d_hardness * 0x010101));
                if ($edge3d_size > 0)
                    $this->drawShadedPie($im, $cx, $cy, $rad - $edge3d_size, $rad - $edge3d_size, $a, $aa, $this->colourSub($col, $edge3d_hardness * 0x010101), $this->colourAdd($col, $edge3d_hardness * 0x010101));
                if ($hole_size > 0 && $edge3d_size > 0)
                    $this->drawShadedPie($im, $cx, $cy, $rad * $hole_size + $edge3d_size, $rad * $hole_size + $edge3d_size, $a, $aa, $this->colourSub($col, $edge3d_hardness * 0x020202), $this->colourAdd($col, $edge3d_hardness * 0x020202));

                $a = $aa;
            }
        }

        //  Draw lines

        $a = 0;

        for ($i = 0; $i < $n; $i++) {
            $x1 = $cx + sin($a * 3.14159 * 2) * ($rad - 0.45);
            $y1 = $cy - cos($a * 3.14159 * 2) * ($rad - 0.45);
            $x2 = $cx + sin($a * 3.14159 * 2) * $rad * 0;
            $y2 = $cy - cos($a * 3.14159 * 2) * $rad * 0;

            $this->drawLine($im, $x1, $y1, $x2, $y2, 0x00000000);

            $a += $this->data[$i]['value'] / $this->total;
        }

        if ($hole_size > 0) {
            //  Black inner line

            $this->drawShadedElipse($im, $cx, $cy, $rad * $hole_size - 1, $rad * $hole_size - 1, 0x000000);

            //  Shaded background showing through

            $c1 = $this->colourBlend($this->bg1, $this->bg2, ($cy - ($rad * $hole_size - 2)) / $h);
            $c2 = $this->colourBlend($this->bg1, $this->bg2, ($cy + ($rad * $hole_size - 2)) / $h);
            $this->drawShadedElipse($im, $cx, $cy, $rad * $hole_size - 2, $rad * $hole_size - 2, $c1, $c2);
        }

        //- Draw legend

        if ($legend_width > 0) {
            if ($legend_pos == 0) {
                $legend_x1 = $padding;
                $legend_x2 = intval($w * ($legend_width) - $padding * 0.5);
            }
            else {
                $legend_x1 = intval($w * (1 - $legend_width) + $padding * 0.5);
                $legend_x2 = intval($w - $padding);
            }

            //  Work out height based on fonts and word-wrapping

            $text_h = 0;
            $text_array = array();

            for ($i = 0; $i < $n; $i++) {
                $lines = $this->getWrappedText($legend_font, $legend_font_size, $legend_x2 - $legend_x1 - $legend_box_padding * 2 - $legend_key_padding - $legend_key_size, $this->data[$i]['name']);

                $box = $this->getTextBoundingBox($legend_font_size, 0, $legend_font, join("\n", $lines));
                $box_h = $box[1] - $box[5];

                if ($box_h < $legend_key_size) {
                    $box_h = $legend_key_size;
                }
                $text_h += $box_h;

                $text_array[] = array('height' => $box_h,
                    'lines' => $lines);
            }

            $legend_h = $legend_box_padding * 2 + $text_h + $legend_between_padding * ($n - 1);

            if ($legend_valign < 0) //  Top
            {
                $legend_y1 = intval($padding);

                if ($title_pos == 0) {
                    $legend_y1 += $title_h;
                }
            }
            else if ($legend_valign == 0) //  Middle
            {
                $legend_y1 = ($h - $legend_h) * 0.5;

                if ($title_pos == 0) {
                    $legend_y1 += $title_h / 2;
                }
                else {
                    $legend_y1 -= $title_h / 2;
                }
            }
            else //  Bottom
            {
                $legend_y1 = $h - $legend_h - intval($padding);

                if ($title_pos != 0) {
                    $legend_y1 -= $title_h;
                }
            }

            $legend_y2 = $legend_y1 + $legend_h;

            //  Background

            imagefilledrectangle($im, $legend_x1, $legend_y1, $legend_x2, $legend_y2, $legend_bg);
            imagerectangle($im, $legend_x1, $legend_y1, $legend_x2, $legend_y2, $legend_border);

            //  Coloured boxes and text

            $x1 = $legend_x1 + $legend_box_padding;
            $y1 = $legend_y1 + $legend_box_padding;

            $box = $this->getTextBoundingBox($legend_font_size, 0, $legend_font, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
            $line_top = -$box[5];

            for ($i = 0; $i < $n; $i++) {
                $col = $this->data[$i]['colour'];

                imagefilledrectangle($im, $x1, $y1, $x1 + $legend_key_size, $y1 + $legend_key_size, $col);
                imagerectangle($im, $x1, $y1, $x1 + $legend_key_size, $y1 + $legend_key_size, 0x000000);

                imagettftext($im, $legend_font_size, 0, $x1 + $legend_key_size + $legend_key_padding, $y1 + $line_top, $legend_font_col, $legend_font, join("\n", $text_array[$i]['lines']));

                $box_h = $text_array[$i]['height'];
                if ($box_h < $legend_key_size) {
                    $box_h = $legend_key_size;
                }

                $y1 += $box_h + $legend_between_padding;
            }
        }

        //- Return image

        return $im;
    }

    /**
     * @param $font
     * @return bool|string
     */
    private function getFont($font)
    {
        if ($font === false) {
            return false;
        }
        if ($font == '') {
            $font = $this->default_font;
        }
        if (strpos($font, '/') === false) {
            $font = dirname(__file__) . '/' . $font;
        }

        if (!file_exists($font)) {
            $this->error("Could not find font: '$font'");
        }

        return $font;
    }

    /**
     * @param $error
     */
    private function error($error)
    {
        header('Content-type: text/html');
        echo '<h1>ChartLogix Error (PieChart)</h1><p>' . $error . '</p>';
        exit();
    }

    /**
     * @param int $c1
     * @param int $c2
     * @param float $f 0.0 for $c1, 1.0 for $c2
     * @return int Blended colour
     */
    private function colourBlend($c1, $c2, $f)
    {
        if ($f < 0) {
            $f = 0;
        }
        if ($f > 1) {
            $f = 1;
        }

        $r1 = ($c1 >> 16) & 0xFF;
        $g1 = ($c1 >> 8) & 0xFF;
        $b1 = ($c1) & 0xFF;

        $r2 = ($c2 >> 16) & 0xFF;
        $g2 = ($c2 >> 8) & 0xFF;
        $b2 = ($c2) & 0xFF;

        $r = $r1 * (1 - $f) + $r2 * $f;
        $g = $g1 * (1 - $f) + $g2 * $f;
        $b = $b1 * (1 - $f) + $b2 * $f;

        return (intval($r) << 16) + (intval($g) << 8) + (intval($b));
    }

    /**
     * @param $c1
     * @param $c2
     * @return int
     */
    private function colourAdd($c1, $c2)
    {
        if ($c2 < 0) {
            return $this->colourSub($c1, -$c2);
        }

        $r1 = ($c1 >> 16) & 0xFF;
        $g1 = ($c1 >> 8) & 0xFF;
        $b1 = ($c1) & 0xFF;

        $r2 = ($c2 >> 16) & 0xFF;
        $g2 = ($c2 >> 8) & 0xFF;
        $b2 = ($c2) & 0xFF;

        $r = $r1 + $r2;
        $g = $g1 + $g2;
        $b = $b1 + $b2;

        if ($r > 255) {
            $r = 255;
        }
        if ($g > 255) {
            $g = 255;
        }
        if ($b > 255) {
            $b = 255;
        }

        return (intval($r) << 16) + (intval($g) << 8) + (intval($b));
    }

    /**
     * @param $c1
     * @param $c2
     * @return int
     */
    private function colourSub($c1, $c2)
    {
        if ($c2 < 0) {
            return $this->colourAdd($c1, -$c2);
        }

        $r1 = ($c1 >> 16) & 0xFF;
        $g1 = ($c1 >> 8) & 0xFF;
        $b1 = ($c1) & 0xFF;

        $r2 = ($c2 >> 16) & 0xFF;
        $g2 = ($c2 >> 8) & 0xFF;
        $b2 = ($c2) & 0xFF;

        $r = $r1 - $r2;
        $g = $g1 - $g2;
        $b = $b1 - $b2;

        if ($r < 0)
            $r = 0;
        if ($g < 0)
            $g = 0;
        if ($b < 0)
            $b = 0;

        return (intval($r) << 16) + (intval($g) << 8) + (intval($b));
    }

    /**
     * @param $font
     * @param $size
     * @param $w
     * @param $text
     * @return array
     */
    private function getWrappedText($font, $size, $w, $text)
    {
        //  Break up sentence into words

        $words = array();
        $word = '';

        for ($i = 0; $i < strlen($text); $i++) {
            $c = $text[$i];
            $word .= $c;

            switch ($c) {
                case ' ';
                case ',';
                case '.';
                case ':';
                case ';';
                case '-';
                    if (trim($word) <> '')
                        $words[] = $word;
                    $word = '';
                    break;

                default:
                    break;
            }
        }

        if (trim($word) <> '') {
            $words[] = $word;
        }

        //  Take a word at a time, getting width until it wraps

        $lines = array();
        $line = '';

        $h = 0;

        for ($i = 0; $i < count($words); $i++) {
            if ($line == '') {
                $line = $words[$i];
            }
            else {
                $box = $this->getTextBoundingBox($size, 0, $font, $line . rtrim($words[$i]));
                $box_w = $box[2] - $box[0];

                if ($box_w > $w) {
                    $lines[] = rtrim($line);
                    $line = $words[$i];
                }
                else {
                    $line .= $words[$i];
                }
            }
        }

        if ($line != '') {
            $lines[] = rtrim($line);
        }

        //  Return array of lines

        return $lines;
    }

    /**
     * @param $im
     * @param $x1
     * @param $y1
     * @param $x2
     * @param $y2
     * @param $col
     */
    private function drawLine($im, $x1, $y1, $x2, $y2, $col)
    {
        $dx = $x2 - $x1;
        $dy = $y2 - $y1;

        if (abs($dx) > abs($dy)) //  Horizontal is main axis
        {
            if ($x1 > $x2) {
                $t = $x1;
                $x1 = $x2;
                $x2 = $t;
                $t = $y1;
                $y1 = $y2;
                $y2 = $t;
            }

            for ($i = intval($x1); $i <= $x2; $i++) {
                $y = $y1 + ($y2 - $y1) * ($i - $x1) / ($x2 - $x1) - 0.5;
                $f = $y - intval($y);

                $f1 = ($f * 127);
                $f2 = 127 - ($f * 127);

                imagesetpixel($im, $i, intval($y), $col + ($f1 << 24));
                imagesetpixel($im, $i, intval($y) + 1, $col + ($f2 << 24));
            }
        }
        else //  Vertical is main axis
        {
            if ($y1 > $y2) {
                $t = $x1;
                $x1 = $x2;
                $x2 = $t;
                $t = $y1;
                $y1 = $y2;
                $y2 = $t;
            }

            for ($i = intval($y1); $i <= $y2; $i++) {
                $x = $x1 + ($x2 - $x1) * ($i - $y1) / ($y2 - $y1) - 0.5;
                $f = $x - intval($x);

                $f1 = ($f * 127);
                $f2 = 127 - ($f * 127);

                imagesetpixel($im, intval($x), $i, $col + ($f1 << 24));
                imagesetpixel($im, intval($x) + 1, $i, $col + ($f2 << 24));
            }
        }
    }

    /**
     * Angles: 0 is up, 0.25 is right, 0.5 is down, 0.75 is left
     * @param $im
     * @param $cx
     * @param $cy
     * @param $rx
     * @param $ry
     * @param $a1
     * @param $a2
     * @param $col1
     * @param bool $col2
     * @return mixed
     */
    private function drawShadedPie($im, $cx, $cy, $rx, $ry, $a1, $a2, $col1, $col2 = false)
    {
        if ($rx <= 0 || $ry <= 0) {
            return;
        }
        if ($a1 == $a2) {
            return;
        }

        if ($col2 === false) {
            $col2 = $col1;
        }

        if ($a1 >= 0.75) {
            $a1 -= 1.0;
        }
        if ($a2 >= 0.75) {
            $a2 -= 1.0;
        }

        $y1 = $cy - $ry;
        $y2 = $cy + $ry;

        $t1 = $a1 <= 0.25;
        $t2 = $a2 <= 0.25;

        $tan1 = tan($a1 * 3.14159265 * 2.0);
        $tan2 = tan($a2 * 3.14159265 * 2.0);

        for ($y = intval($y1); $y < $y2; $y++) {
            $col = $this->colourBlend($col1, $col2, ($y - $y1) / ($y2 - $y1));

            //  Calculate the x start and end for 10 subdivisions of the scanline

            $lines = array();
            $slice = array(); //  Used to cut a slice out of the circle if necessary

            $x1min = $cx + $rx;
            $x1max = $cx - $rx;
            $x2min = $cx + $rx;
            $x2max = $cx - $rx;

            $sx1min = $cx + $rx;
            $sx1max = $cx - $rx;
            $sx2min = $cx + $rx;
            $sx2max = $cx - $rx;

            $blank = false; //  Whether there are any blank scanlines
            $blank_slice = false;

            for ($yd = 0; $yd < 10; $yd++) {
                $yy = $y + 0.1 * $yd + 0.05;
                $yu = ($yy - $cy) / $ry; //  Y scaled to -1 .. 1

                if ($yu > -1.0 && $yu < 1.0) {
                    $xu = sqrt(1.0 - $yu * $yu);

                    $x1 = $cx - $rx * $xu;
                    $x2 = $cx + $rx * $xu;

                    //  Now do pie slice calculations

                    if ($t1) {
                        if ($t2) {
                            if ($a1 < $a2) {
                                //  A - Simple pie all in top half

                                $a1x = $cx + ($cy - $yy) * $tan1;
                                $a2x = $cx + ($cy - $yy) * $tan2;

                                if ($x1 < $a1x) {
                                    $x1 = $a1x;
                                }
                                if ($x2 > $a2x) {
                                    $x2 = $a2x;
                                }
                            }
                            else {
                                if ($yu < 0) {
                                    //  B - Pac-man, with lines in top half

                                    $ax_l = $cx + ($cy - $yy) * $tan2;
                                    $ax_r = $cx + ($cy - $yy) * $tan1;

                                    //  Check if we need to slice, or just clip

                                    if ($x2 > $ax_l && $x1 < $ax_r) {
                                        $slice[$yd] = array($ax_l, $ax_r);
                                    }
                                }
                            }
                        }
                        else {
                            //  C - pie in RHS with start in top and end in bottom

                            if ($yu <= 0) {
                                $a1x = $cx + ($cy - $yy) * $tan1;
                                if ($x1 < $a1x) {
                                    $x1 = $a1x;
                                }
                            }
                            else {
                                $a1x = $cx + ($cy - $yy) * $tan2;
                                if ($x1 < $a1x) {
                                    $x1 = $a1x;
                                }
                            }
                        }
                    }
                    else {
                        if ($t2) {
                            //  D - Pie in LHS starting from bottom and ending at top

                            if ($yu <= 0) {
                                $a1x = $cx + ($cy - $yy) * $tan2;
                                if ($x2 > $a1x) {
                                    $x2 = $a1x;
                                }
                            }
                            else {
                                $a1x = $cx + ($cy - $yy) * $tan1;
                                if ($x2 > $a1x) {
                                    $x2 = $a1x;
                                }
                            }
                        }
                        else {
                            if ($a1 > $a2) {
                                //  E - both lines in bottom, pie all the way round the top

                                $ax_l = $cx + ($cy - $yy) * $tan1;
                                $ax_r = $cx + ($cy - $yy) * $tan2;

                                //  Check if we need to slice, or just clip

                                if ($x2 > $ax_l && $x1 < $ax_r) {
                                    $slice[$yd] = array($ax_l, $ax_r);
                                }
                            }
                            else {
                                //  F - simple pie in bottom

                                $a1x = $cx + ($cy - $yy) * $tan2;
                                $a2x = $cx + ($cy - $yy) * $tan1;

                                if ($x1 < $a1x) {
                                    $x1 = $a1x;
                                }
                                if ($x2 > $a2x) {
                                    $x2 = $a2x;
                                }
                            }
                        }
                    }

                    if (isset($slice[$yd])) {
                        if ($slice[$yd][0] < $sx1min) {
                            $sx1min = $slice[$yd][0];
                        }
                        if ($slice[$yd][0] > $sx1max) {
                            $sx1max = $slice[$yd][0];
                        }
                        if ($slice[$yd][1] < $sx2min) {
                            $sx2min = $slice[$yd][1];
                        }
                        if ($slice[$yd][1] > $sx2max) {
                            $sx2max = $slice[$yd][1];
                        }
                    }

                    if ($x1 < $x1min) {
                        $x1min = $x1;
                    }
                    if ($x1 > $x1max) {
                        $x1max = $x1;
                    }
                    if ($x2 < $x2min) {
                        $x2min = $x2;
                    }
                    if ($x2 > $x2max) {
                        $x2max = $x2;
                    }

                    $lines[$yd] = array($x1, $x2);
                }
                else {
                    $blank = true;
                }
            }

            //- Now use this information to render pixels and subpixels

            if ($x1min < $x2max) //  There is a line at all
            {
                //- The two antialiased portions do not meet in the same pixel

                if (intval($x1max) < intval($x2min) && !$blank) {
                    //- No slice taken out

                    if (count($slice) == 0) {
                        //- Loop for left-hand antialiasing

                        for ($i = intval($x1min); $i <= $x1max; $i++) {
                            $f = 0;

                            for ($j = 0; $j < 10; $j++) {
                                if ($lines[$j][0] <= $i) {
                                    $f += 0.1;
                                }
                                else if ($lines[$j][0] < $i + 1) {
                                    $f += 0.1 - 0.1 * ($lines[$j][0] - $i);
                                }
                            }

                            $f = 127 - intval((127.0 * $f));

                            imagesetpixel($im, $i, $y, $col + ($f << 24));
                        }

                        //- Draw solid middle portion

                        if ($i <= intval($x2min) - 1) {
                            imageline($im, $i, $y, intval($x2min) - 1, $y, $col);
                        }

                        //- Loop for right-hand antialiasing

                        for ($i = intval($x2min); $i <= $x2max; $i++) {
                            $f = 0;

                            for ($j = 0; $j < 10; $j++) {
                                if ($lines[$j][1] >= $i + 1) {
                                    $f += 0.1;
                                }
                                else if ($lines[$j][1] > $i) {
                                    $f += 0.1 * ($lines[$j][1] - $i);
                                }
                            }

                            $f = 127 - intval(127.0 * $f);
                            imagesetpixel($im, $i, $y, $col + ($f << 24));
                        }
                    }

                    //- There is a slice

                    else {
                        //- Check whether the left and right sections exist

                        $section1 = $x1min < $sx1max;
                        $section2 = $sx2min < $x2max;

                        $seperate = intval($sx1max) < intval($sx2min);

                        if ($seperate) {
                            if ($section1) {
                                //- Loop for AA section 1 LHS

                                for ($i = intval($x1min); $i <= $x1max; $i++) {
                                    $f = 0;

                                    for ($j = 0; $j < 10; $j++) {
                                        $a = $i;
                                        $b = $i + 1;

                                        if ($lines[$j][0] > $a) {
                                            $a = $lines[$j][0];
                                        }
                                        if ($slice[$j] && $slice[$j][0] < $b) {
                                            $b = $slice[$j][0];
                                        }

                                        if ($a < $b) {
                                            $f += 0.1 * ($b - $a);
                                        }
                                    }

                                    $f = 127 - intval((127.0 * $f));

                                    imagesetpixel($im, $i, $y, $col + ($f << 24));
                                }

                                //- Solid section 1

                                if ($i <= intval($sx1min) - 1) {
                                    imageline($im, $i, $y, intval($sx1min) - 1, $y, $col);
                                }

                                //- Loop for AA section 1 RHS

                                for ($i = intval($sx1min); $i <= $sx1max; $i++) {
                                    $f = 0;

                                    for ($j = 0; $j < 10; $j++) {
                                        $a = $i;
                                        $b = $i + 1;

                                        if ($lines[$j][0] > $a) {
                                            $a = $lines[$j][0];
                                        }
                                        if ($slice[$j] && $slice[$j][0] < $b) {
                                            $b = $slice[$j][0];
                                        }

                                        if ($slice[$j] && $a < $b) {
                                            $f += 0.1 * ($b - $a);
                                        }
                                    }

                                    $f = 127 - intval((127.0 * $f));

                                    imagesetpixel($im, $i, $y, $col + ($f << 24));
                                }
                            }

                            if ($section2) {
                                //- Loop for AA section 2 LHS

                                for ($i = intval($sx2min); $i <= $sx2max; $i++) {
                                    $f = 0;

                                    for ($j = 0; $j < 10; $j++) {
                                        $a = $i;
                                        $b = $i + 1;

                                        if ($slice[$j] && $slice[$j][1] > $a) {
                                            $a = $slice[$j][1];
                                        }
                                        if ($lines[$j][1] < $b) {
                                            $b = $lines[$j][1];
                                        }

                                        if ($a < $b) {
                                            $f += 0.1 * ($b - $a);
                                        }
                                    }

                                    $f = 127 - intval((127.0 * $f));

                                    imagesetpixel($im, $i, $y, $col + ($f << 24));
                                }

                                //- Solid section 2

                                if ($i <= intval($x2min) - 1) {
                                    imageline($im, $i, $y, intval($x2min) - 1, $y, $col);
                                }

                                //- Loop for AA section 2 RHS

                                for ($i = intval($x2min); $i <= $x2max; $i++) {
                                    $f = 0;

                                    for ($j = 0; $j < 10; $j++) {
                                        $a = $i;
                                        $b = $i + 1;

                                        if ($slice[$j] && $slice[$j][1] > $a) {
                                            $a = $slice[$j][1];
                                        }
                                        if ($lines[$j][1] < $b) {
                                            $b = $lines[$j][1];
                                        }

                                        if ($a < $b) {
                                            $f += 0.1 * ($b - $a);
                                        }
                                    }

                                    $f = 127 - intval(127.0 * $f);
                                    imagesetpixel($im, $i, $y, $col + ($f << 24));
                                }
                            }
                        }
                        else //  Not separate
                        {
                            if ($section1) {
                                //- Loop for AA section 1 LHS

                                for ($i = intval($x1min); $i <= $x1max && $i < intval($sx1min); $i++) {
                                    $f = 0;

                                    for ($j = 0; $j < 10; $j++) {
                                        $a = $i;
                                        $b = $i + 1;

                                        if ($lines[$j][0] > $a) {
                                            $a = $lines[$j][0];
                                        }
                                        if ($slice[$j] && $slice[$j][0] < $b) {
                                            $b = $slice[$j][0];
                                        }

                                        if ($a < $b) {
                                            $f += 0.1 * ($b - $a);
                                        }
                                    }

                                    $f = 127 - intval((127.0 * $f));

                                    imagesetpixel($im, $i, $y, $col + ($f << 24));
                                }

                                //- Solid section 1

                                if ($i < intval($sx1min)) {
                                    imageline($im, $i, $y, intval($sx1min) - 1, $y, $col);
                                }
                            }

                            //- Antialiased bit between section1 and section2

                            for ($i = intval($sx1min); $i <= $sx2max; $i++) {
                                $f = 0;

                                for ($k = 0; $k < 10; $k++) //  sub-pixel X value
                                {
                                    for ($j = 0; $j < 10; $j++) {
                                        $kk = $i + $k * 0.1 + 0.05;

                                        if ($lines[$j][0] <= $kk && $lines[$j][1] > $kk) //  IF within bounds of line
                                        {
                                            if (!($slice[$j] && $slice[$j][0] <= $kk && $slice[$j][1] > $kk)) //  IF NOT inside bounds of slice (if there is one)
                                            {
                                                $f += 0.01;
                                            }
                                        }
                                    }
                                }

                                $f = 127 - intval((127.0 * $f));

                                imagesetpixel($im, $i, $y, $col + ($f << 24));
                            }

                            if ($section2) {
                                //- Solid section 2

                                if ($i <= intval($x2min) - 1) {
                                    imageline($im, $i, $y, intval($x2min) - 1, $y, $col);
                                }

                                //- Loop for AA section 2 RHS

                                for ($i = intval($x2min); $i <= $x2max; $i++) {
                                    $f = 0;

                                    for ($j = 0; $j < 10; $j++) {
                                        $a = $i;
                                        $b = $i + 1;

                                        if ($slice[$j] && $slice[$j][1] > $a) {
                                            $a = $slice[$j][1];
                                        }
                                        if ($lines[$j][1] < $b) {
                                            $b = $lines[$j][1];
                                        }

                                        if ($a < $b) {
                                            $f += 0.1 * ($b - $a);
                                        }
                                    }

                                    $f = 127 - intval(127.0 * $f);
                                    imagesetpixel($im, $i, $y, $col + ($f << 24));
                                }
                            }
                        }
                    }
                }

                //- Antialiased all the way along this scanline

                else {
                    for ($i = intval($x1min); $i <= $x2max; $i++) {
                        $f = 0;

                        for ($j = 0; $j < 10; $j++) {
                            if (isset($lines[$j])) {
                                $x1 = $lines[$j][0];
                                $x2 = $lines[$j][1];

                                if ($x1 < $i) {
                                    $x1 = $i;
                                }
                                if ($x2 > $i + 1) {
                                    $x2 = $i + 1;
                                }

                                if ($x1 < $x2) {
                                    $f += 0.1 * ($x2 - $x1);
                                }
                            }
                        }

                        $f = 127 - intval(127.0 * $f);
                        imagesetpixel($im, $i, $y, $col + ($f << 24));
                    }
                }
            }
        }
    }

    /**
     * @param $im
     * @param $cx
     * @param $cy
     * @param $rx
     * @param $ry
     * @param $col1
     * @param bool $col2
     * @return mixed
     */
    private function drawShadedElipse($im, $cx, $cy, $rx, $ry, $col1, $col2 = false)
    {
        if ($rx <= 0 || $ry <= 0) {
            return;
        }

        if ($col2 === false) {
            $col2 = $col1;
        }

        $y1 = $cy - $ry;
        $y2 = $cy + $ry;

        for ($y = intval($y1); $y < $y2; $y++) {
            $col = $this->colourBlend($col1, $col2, ($y - $y1) / ($y2 - $y1));

            //  Calculate the x start and end for 10 subdivisions of the scanline

            $lines = array();

            $x1min = $cx + $rx;
            $x1max = $cx - $rx;
            $x2min = $cx + $rx;
            $x2max = $cx - $rx;

            $blank = false; //  Whether there are any blank scanlines

            for ($yd = 0; $yd < 10; $yd++) {
                $yy = $y + 0.1 * $yd + 0.05;

                $yu = ($yy - $cy) / $ry;

                if ($yu > -1.0 && $yu < 1.0) {
                    $xu = sqrt(1.0 - $yu * $yu);

                    $x1 = $cx - $rx * $xu;
                    $x2 = $cx + $rx * $xu;

                    if ($x1 < $x1min) {
                        $x1min = $x1;
                    }
                    if ($x1 > $x1max) {
                        $x1max = $x1;
                    }
                    if ($x2 < $x2min) {
                        $x2min = $x2;
                    }
                    if ($x2 > $x2max) {
                        $x2max = $x2;
                    }

                    $lines[$yd] = array($x1, $x2);
                }
                else {
                    $lines[$yd] = false;
                    $blank = true;
                }
            }

            //- Now use this information to render pixels and subpixels

            if ($x1min < $x2max) //  There is a line at all
            {
                //- The two antialiased portions do not meet in the same pixel

                if (intval($x1max) < intval($x2min) && !$blank) {
                    //- Loop for left-hand antialiasing

                    for ($i = intval($x1min); $i <= $x1max; $i++) {
                        $f = 0;

                        for ($j = 0; $j < 10; $j++) {
                            if ($lines[$j][0] <= $i) {
                                $f += 0.1;
                            }
                            else if ($lines[$j][0] < $i + 1) {
                                $f += 0.1 - 0.1 * ($lines[$j][0] - $i);
                            }
                        }

                        $f = 127 - intval((127.0 * $f));

                        imagesetpixel($im, $i, $y, $col + ($f << 24));
                    }

                    //- Draw solid middle portion

                    imageline($im, $i, $y, intval($x2min) - 1, $y, $col);

                    //- Loop for right-hand antialiasing

                    for ($i = intval($x2min); $i <= $x2max; $i++) {
                        $f = 0;

                        for ($j = 0; $j < 10; $j++) {
                            if ($lines[$j][1] >= $i + 1) {
                                $f += 0.1;
                            }
                            else if ($lines[$j][1] > $i) {
                                $f += 0.1 * ($lines[$j][1] - $i);
                            }
                        }

                        $f = 127 - intval(127.0 * $f);
                        imagesetpixel($im, $i, $y, $col + ($f << 24));
                    }
                }

                //- Antialiased all the way along this scanline

                else {
                    for ($i = intval($x1min); $i <= $x2max; $i++) {
                        $f = 0;

                        for ($j = 0; $j < 10; $j++) {
                            if ($lines[$j]) {
                                $x1 = $lines[$j][0];
                                $x2 = $lines[$j][1];

                                if ($x1 < $i) {
                                    $x1 = $i;
                                }
                                if ($x2 > $i + 1) {
                                    $x2 = $i + 1;
                                }

                                if ($x1 < $x2) {
                                    $f += 0.1 * ($x2 - $x1);
                                }
                            }
                        }

                        $f = 127 - intval(127.0 * $f);
                        imagesetpixel($im, $i, $y, $col + ($f << 24));
                    }
                }
            }
        }
    }

    /**
     * getTextBoundingBox
     *
     * Provides a better answer than imagettfbox does for angled text
     * Calculates the bounding box of the text horizontally (which imagettfbox gets right) and then rotates the box
     *
     * @param int $size
     * @param float $angle
     * @param string $font
     * @param string $text
     *
     * @return array The points of non axis-aligned bounding rectangle
     */
    private function getTextBoundingBox($size, $angle, $font, $text)
    {
        //  This does it properly by getting the bounding box for horizontal text then rotating it

        if (!file_exists($font)) {
            $this->error("Could not find font: '$font'");
        }

        $box = imagettfbbox($size, 0, $font, $text);

        $s = sin(-$angle * 3.1415926 / 180);
        $c = cos(-$angle * 3.1415926 / 180);

        return array
        (
            $c * $box[0] - $s * $box[1],
            $s * $box[0] + $c * $box[1],
            $c * $box[2] - $s * $box[3],
            $s * $box[2] + $c * $box[3],
            $c * $box[4] - $s * $box[5],
            $s * $box[4] + $c * $box[5],
            $c * $box[6] - $s * $box[7],
            $s * $box[6] + $c * $box[7],
        );
    }

    /**
     * hexcol
     *
     * @param $t
     * @return int|string
     */
    private function hexcol($t)
    {
        if (is_integer($t)) {
            return $t;
        }
        else if (is_string($t)) {
            if ($t[0] == '#')
                $t = substr($t, 1);
            $t = strtoupper($t);

            $h = "0123456789ABCDEF";
            $c = 0;

            for ($i = 0; $i < strlen($t); $i++) {
                $c <<= 4;

                $p = strpos($h, $t[$i]);
                if ($p !== false) {
                    $c += $p;
                }
            }

            return $c;
        }
        else {
            return 0xFF00FF;
        }
    }

    /**
     * @param $im
     * @param int $thumb_w
     * @param int $thumb_h
     * @return resource
     */
    private function convertToThumbnail($im, $thumb_w = 0, $thumb_h = 0)
    {
        if ($thumb_w <= 0 && $thumb_h <= 0) {
            return $im;
        }

        $w = imagesx($im);
        $h = imagesy($im);

        if ($thumb_w == 0) {
            $thumb_w = $w * $thumb_h / $h;
        }
        else if ($thumb_h == 0) {
            $thumb_h = $h * $thumb_w / $w;
        }

        $im2 = imagecreatetruecolor($thumb_w, $thumb_h);
        imagecopyresampled($im2, $im, 0, 0, 0, 0, $thumb_w, $thumb_h, $w, $h);
        imagedestroy($im);

        return $im2;
    }


}



?>