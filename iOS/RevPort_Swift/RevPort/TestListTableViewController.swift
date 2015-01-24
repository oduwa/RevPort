//
//  TestListTableViewController.swift
//  RevPort
//
//  Created by Odie Edo-Osagie on 22/01/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

import UIKit

class TestListTableViewController: UITableViewController {

    var testModule : PFObject!;
    var tests = Array<PFObject>();
    var questionCounts = Array<PFObject>();
    var scores = Array<PFObject>();
    var questionsToShow = Array<PFObject>();
    
    var answersToShow = Array<String>();
    var choicesToShow = Array<String>();
    
    /* Sub Views */
    var activityIndicator : UIActivityIndicatorView!;
    
    override func viewDidLoad() {
        super.viewDidLoad()

        /* Nav Bar */
        var moduleName = testModule["moduleName"] as String;
        self.title = moduleName;
        
        
        /* Activity Indicator */
        activityIndicator = UIActivityIndicatorView(activityIndicatorStyle: UIActivityIndicatorViewStyle.Gray);
        activityIndicator.center = self.view.center;
        activityIndicator.hidesWhenStopped = true;
        self.view.addSubview(activityIndicator);
        activityIndicator.hidden = false;
        
        fetchTests();
        
        NSNotificationCenter.defaultCenter().addObserver(self, selector: Selector("showAnswers:"), name: "ShowAnswersNotif", object: nil);
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    // MARK: - Table view data source

    override func numberOfSectionsInTableView(tableView: UITableView) -> Int {
        // Return the number of sections.
        return 1
    }

    override func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        // Return the number of rows in the section.
        return self.tests.count;
    }

    
    override func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCellWithIdentifier("cell", forIndexPath: indexPath) as TestListTableViewCell
        
        // Configure the cell...
        var testTitle = self.tests[indexPath.row]["testTitle"] as String;
        var gradeable = self.tests[indexPath.row]["gradeable"] as Bool;
        var count = self.tests[indexPath.row]["questionCount"] as Int;
        var score = 0.0;
        if(self.tests[indexPath.row]["score_temp"] != nil){
            score =  self.tests[indexPath.row]["score_temp"] as Double;
            score = AppUtils.sharedInstance.roundToDecimalPlaces(score, decimalPlaces: 2);
            cell.scoreLabel.text = "\(score)%";
        }
        else{
            cell.scoreLabel.text = "";
        }
        
        
        cell.titleLabel.text = testTitle;
        cell.questionCountLabel.text = "Questions: \(count)";
        if(gradeable){
            cell.typeLabel.text = "GRADED";
        }
        else{
            cell.typeLabel.text = "PRACTICE";
        }
        

        return cell
    }
    
    override func tableView(tableView: UITableView, didSelectRowAtIndexPath indexPath: NSIndexPath) {
        
        activityIndicator.startAnimating();
        
        /* Get Questions */
        var test = self.tests[indexPath.row];
        var questionRelation = test.relationForKey("questions");
        var query = questionRelation.query();
        query.findObjectsInBackgroundWithBlock { (objects: [AnyObject]!, error: NSError!) -> Void in
            if(error == nil){
                // store retreived questions list
                self.questionsToShow = objects as Array<PFObject>;
                self.performSegueWithIdentifier("showQuestion", sender: self);
            }
            else{
                // error
            }
            
            self.activityIndicator.stopAnimating();
        }
        
        
    }
    

    /*
    // Override to support conditional editing of the table view.
    override func tableView(tableView: UITableView, canEditRowAtIndexPath indexPath: NSIndexPath) -> Bool {
        // Return NO if you do not want the specified item to be editable.
        return true
    }
    */

    /*
    // Override to support editing the table view.
    override func tableView(tableView: UITableView, commitEditingStyle editingStyle: UITableViewCellEditingStyle, forRowAtIndexPath indexPath: NSIndexPath) {
        if editingStyle == .Delete {
            // Delete the row from the data source
            tableView.deleteRowsAtIndexPaths([indexPath], withRowAnimation: .Fade)
        } else if editingStyle == .Insert {
            // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
        }    
    }
    */

    /*
    // Override to support rearranging the table view.
    override func tableView(tableView: UITableView, moveRowAtIndexPath fromIndexPath: NSIndexPath, toIndexPath: NSIndexPath) {

    }
    */

    /*
    // Override to support conditional rearranging of the table view.
    override func tableView(tableView: UITableView, canMoveRowAtIndexPath indexPath: NSIndexPath) -> Bool {
        // Return NO if you do not want the item to be re-orderable.
        return true
    }
    */
    
    
    // MARK: - Helper
    func fetchTests(){

        self.activityIndicator.startAnimating();
        
        var relation = testModule.relationForKey("tests");
        var query = relation.query();
        query.orderByAscending("createdAt");
        query.findObjectsInBackgroundWithBlock {
            (objects: [AnyObject]!, error: NSError!) -> Void in
            if(error == nil) {
                // Add test to data source
                for object in objects {
                    var test : PFObject = object as PFObject;
                    self.tests.append(test);
                }
                
                // Get scores
                for test in self.tests {
                    self.activityIndicator.startAnimating();
                    var currentUsername = PFUser.currentUser().username;
                    var attempters = test["attempters"] as Array<String>;
                    if(contains(attempters, currentUsername)){
                        var scoreRelation = test.relationForKey("scores");
                        var scoreQuery = scoreRelation.query();
                        scoreQuery.whereKey("username", equalTo: currentUsername);
                        scoreQuery.getFirstObjectInBackgroundWithBlock({ (score, error) -> Void in
                            if(error == nil){
                                test["score_temp"] = score["mark"];
                            }
                            else{
                                test["score_temp"] = "";
                            }
                            self.tableView.reloadData();
                            self.activityIndicator.stopAnimating();
                        })
                    }
                }
                self.activityIndicator.stopAnimating();
                
            } else {
                // Log details of the failure
                var errorInfo : [NSObject : AnyObject] = error!.userInfo!;
                var errorString : NSString = errorInfo["error"] as NSString;
                AppUtils.sharedInstance.makeAlertView("Error", message: errorString, action: "OK", sender: self);
            }
            
            self.tableView.reloadData();
        }
        
    }
    
    
    // MARK: - Selectors
    func showAnswers(notification:NSNotification){
        let userInfo:Dictionary<NSString,NSArray!> = notification.userInfo as Dictionary<NSString,NSArray!>
        self.choicesToShow = userInfo["choices"] as Array<String>;
        self.answersToShow = userInfo["answers"] as Array<String>;

        self.dismissViewControllerAnimated(true, completion: { () -> Void in
            self.performSegueWithIdentifier("showAnswer", sender: self);
        })
    }

    
    // MARK: - Navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
        
        if(segue.identifier == "showQuestion"){
            var questionViewCont = segue.destinationViewController as QuestionViewController;
            questionViewCont.questions = questionsToShow;
            questionViewCont.questionIndex = 0;
        }
        else if(segue.identifier == "showAnswer"){
            var answerViewCont = segue.destinationViewController as AnswerViewController;
            answerViewCont.questions = questionsToShow;
            answerViewCont.choices = choicesToShow;
            answerViewCont.answers = answersToShow;
            answerViewCont.questionIndex = 0;
        }
    }

}
