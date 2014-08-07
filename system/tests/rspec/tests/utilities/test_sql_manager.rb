require './bootstrap.rb'

feature 'SQL Manager' do

  before(:each) do
    cp_session
    @page = SqlManager.new
    @page.load
    no_php_js_errors
  end

  it 'shows the SQL Manager' do
    @page.should have_text 'SQL Manager'
    @page.should have_text 'Total Records'
    @page.should have_text 'Database Tables'
    @page.should have_search_field
    @page.should have_search_btn
    @page.should have_op_select
    @page.should have_op_submit
  end

  it 'should list tables present in the install' do
    tables = []
    $db.query('SHOW TABLES').each(:as => :array) do |row|
      tables << row[0]
    end
    clear_db_result

    @page.tables.map {|source| source.text}.should == tables
    @page.should have(tables.count).tables
  end

  it 'should sort the table' do
    @page.table.find('th.highlight').text.should eq 'Table Name'
    @page.sort_links[0].click

    tables = []
    $db.query('SHOW TABLES').each(:as => :array) do |row|
      tables << row[0]
    end
    clear_db_result

    @page.tables.map {|source| source.text}.should == tables.reverse
    @page.should have(tables.count).tables
    @page.table.find('th.highlight').text.should eq 'Table Name'
  end

  it 'should search the table names' do
    @page.search_field.set 'access'
    @page.search_btn.click

    @page.tables.map {|source| source.text}.should == ['exp_accessories', 'exp_status_no_access', 'exp_template_no_access', 'exp_upload_no_access']
  end

  it 'should sort search results' do
    @page.search_field.set 'access'
    @page.search_btn.click

    @page.sort_links[0].click

    @page.tables.map {|source| source.text}.should == ['exp_accessories', 'exp_status_no_access', 'exp_template_no_access', 'exp_upload_no_access'].reverse
  end

  it 'should validate the table operations submission' do
    @page.op_select.select 'Repair'
    @page.op_submit.click

    no_php_js_errors
    @page.should have_text 'You must select the tables in which to perform this action.'

    @page.op_select.select 'Optimize'
    @page.op_submit.click

    no_php_js_errors
    @page.should have_text 'You must select the tables in which to perform this action.'

    @page.select_all.click
    @page.op_submit.click

    @page.should have_text 'You must select an action to perform on the selected tables.'
  end

  it 'should repair the tables and sort and search the results' do
    @page.select_all.click
    @page.op_select.select 'Repair'
    @page.op_submit.click

    no_php_js_errors
    @page.should have_text 'Repair Table Results'

    tables = []
    $db.query('SHOW TABLES').each(:as => :array) do |row|
      tables << row[0]
    end
    clear_db_result

    @page.tables.map {|source| source.text}.should == tables

    # Go ahead and test sorting
    @page.sort_links[0].click
    no_php_js_errors
    @page.tables.map {|source| source.text}.should == tables.reverse

    # And search
    @page.search_field.set 'access'
    @page.search_btn.click

    @page.tables.map {|source| source.text}.should == ['exp_accessories', 'exp_status_no_access', 'exp_template_no_access', 'exp_upload_no_access'].reverse
  end

  it 'should optimize the tables and sort and search the results' do
    @page.select_all.click
    @page.op_select.select 'Optimize'
    @page.op_submit.click

    no_php_js_errors
    @page.should have_text 'Optimized Table Results'

    tables = []
    $db.query('SHOW TABLES').each(:as => :array) do |row|
      tables << row[0]
    end
    clear_db_result

    @page.tables.map {|source| source.text}.should == tables

    # Go ahead and test sorting
    @page.sort_links[0].click
    no_php_js_errors
    @page.tables.map {|source| source.text}.should == tables.reverse

    # And search
    @page.search_field.set 'access'
    @page.search_btn.click

    @page.tables.map {|source| source.text}.should == ['exp_accessories', 'exp_status_no_access', 'exp_template_no_access', 'exp_upload_no_access'].reverse
  end

  it 'should allow viewing of table contents' do
    @page.manage_links[0].click

    results = QueryResults.new
    no_php_js_errors
    results.should have_text 'SQL Managerexp_accessories Table' # How Capybara sees the breadcrumb
    results.should have_text 'exp_accessories Table'
    results.should have(2).rows

    # Make sure breadcrumb info persists in base URL
    results.sort_links[0].click
    results.should have_text 'SQL Managerexp_accessories Table'
  end
end